<?php

namespace App\Http\Controllers\Cabinet\CabinetUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetUser\UserUpdateRequest;
use App\Models\Contract;
use App\Models\Poll;
use App\Models\PollAnswer;
use App\Models\PollResponse;
use App\Models\Report;
use App\Models\User;
use Domain\CabinetMessage\ViewModels\CabinetMessageViewModel;
use Domain\Service\ViewModels\ServiceViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CabinetUserController extends Controller
{

    /**
     * @return View
     * Страница данных пользователя
     */
    public function cabinetUser(): View
    {

        try {

            $user = UserViewModel::make()->User();
            return view('cabinet.cabinet_user.cabinet_user', [
                'user' => $user
            ]);

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            abort(404);

        }


    }

    /**
     * @return View
     * Страница формы редактирования
     */
    public function cabinetUserUpdate(): View
    {
        try {

            $user = UserViewModel::make()->User();

          //  dd($user);
            return view('cabinet.cabinet_user.cabinet_user_update', [
                'user' => $user
            ]);

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            abort(404);

        }


    }

/**
 * @param UserUpdateRequest $request
 * @return RedirectResponse
 */
    public function cabinetUserUpdateHandel(UserUpdateRequest $request):RedirectResponse
    {

       try {
            $user = UserViewModel::make()->User();
            UserViewModel::make()->UserUpdate($request, $user->id);
            flash()->info(config('message_flash.info.cabinet_user_ok'));
            return redirect()->back();


        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
           flash()->alert(config('message_flash.alert.cabinet_user_error'));
           return redirect()->back();

        }


    }

    /**
     * @return View
     * Страница тарифного плана пользователя
     */
    public function cabinetPricing(): View
    {
        try {

            $user = UserViewModel::make()->User();
            return view('cabinet.cabinet_user.pricing.pricing', [
                'user' => $user
            ]);

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            abort(404);

        }

    }

    /**
     * @return View
     * Страница тарифного плана пользователя
     */
    public function cabinetService(): View
    {
        try {

            $user = UserViewModel::make()->User();
            $items = ServiceViewModel::make()->cabinetService();
            return view('cabinet.cabinet_user.service.services', [
                'user' => $user,
                'items' => ($items)??[]
            ]);

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            abort(404);

        }

    }

    /**
     * @return View
     * Страница с договорами
     */
    public function cabinetContracts(): View
    {
        try {

            /** @var User $user */
            $user = UserViewModel::make()->User();

            $contracts = Contract::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('cabinet.cabinet_user.cabinet_contracts', [
                'user'      => $user,
                'contracts' => $contracts,
            ]);

        } catch (\Throwable $th) {

            logErrors($th);
            abort(404);

        }
    }

    /**
     * @return View
     * Страница с отчётами
     */
    public function cabinetReports(): View
    {
        try {
            /** @var User $user */
            $user = UserViewModel::make()->User();

            $reports = Report::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $unreadCounts = CabinetMessageViewModel::make()->unreadCountsByReportsForUser(
                $reports->pluck('id')->toArray(),
                $user->id,
            );

            return view('cabinet.cabinet_user.cabinet_reports', [
                'user'         => $user,
                'reports'      => $reports,
                'unreadCounts' => $unreadCounts,
            ]);

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * @return View
     * Список голосований, доступных пользователю
     */
    public function cabinetPolls(): View
    {
        try {
            /** @var User $user */
            $user = UserViewModel::make()->User();

            $polls = Poll::where('is_active', true)
                ->latest()
                ->get()
                ->filter(fn(Poll $poll) => $poll->isEligible($user))
                ->values();

            $respondedIds = PollResponse::where('user_id', $user->id)
                ->pluck('poll_id')
                ->flip();

            return view('cabinet.cabinet_user.polls.index', [
                'user'         => $user,
                'polls'        => $polls,
                'respondedIds' => $respondedIds,
            ]);

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * @param int $id
     * @return View
     * Просмотр/прохождение голосования
     */
    public function cabinetPoll(int $id): View
    {
        try {
            /** @var User $user */
            $user = UserViewModel::make()->User();
            $poll = Poll::findOrFail($id);

            if (!$poll->is_active || !$poll->isEligible($user)) {
                abort(403);
            }

            $response = $poll->responseByUser($user->id);

            return view('cabinet.cabinet_user.polls.show', [
                'user'     => $user,
                'poll'     => $poll,
                'response' => $response,
            ]);

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     * Сохранение ответов на голосование
     */
    public function cabinetPollSubmit(int $id, Request $request): RedirectResponse
    {
        try {
            /** @var User $user */
            $user = UserViewModel::make()->User();
            $poll = Poll::findOrFail($id);

            if (!$poll->is_active || !$poll->isEligible($user)) {
                abort(403);
            }

            if ($poll->hasRespondedBy($user->id)) {
                return redirect()->route('cabinet_poll', $poll->id);
            }

            $questions = $poll->questions ?? [];

            $rules = [];
            foreach ($questions as $index => $q) {
                $rules["answers.{$index}"] = ['required', 'string', 'max:5000'];
            }
            $request->validate($rules);

            DB::transaction(function () use ($poll, $user, $request, $questions) {
                $response = PollResponse::create([
                    'poll_id' => $poll->id,
                    'user_id' => $user->id,
                ]);

                foreach ($questions as $index => $q) {
                    PollAnswer::create([
                        'poll_response_id' => $response->id,
                        'question_index'   => $index,
                        'question_text'    => $q['question'] ?? '',
                        'answer'           => $request->input("answers.{$index}"),
                    ]);
                }
            });

            flash()->info(config('message_flash.info.poll_submit_ok'));
            return redirect()->route('cabinet_poll', $poll->id);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.poll_submit_error'));
            return redirect()->back();
        }
    }

    /**
     * @return View
     * Страница с сообщениями
     */
    public function cabinetUserMessages(): View
    {
        try {

            /** @var User $user */
            $user = UserViewModel::make()->User();

            $messages = CabinetMessageViewModel::make()->allMessagesForUser($user->id, 'desc');

            CabinetMessageViewModel::make()->markReadByUser($user->id);

            return view('cabinet.cabinet_user.cabinet_user_messages', [
                'user'     => $user,
                'messages' => $messages,
            ]);

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            abort(404);

        }

    }

}
