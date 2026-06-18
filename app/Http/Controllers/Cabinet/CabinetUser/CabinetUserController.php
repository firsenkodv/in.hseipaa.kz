<?php

namespace App\Http\Controllers\Cabinet\CabinetUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetUser\UserUpdateRequest;
use App\Models\Contract;
use App\Models\Report;
use App\Models\User;
use Domain\CabinetMessage\ViewModels\CabinetMessageViewModel;
use Domain\Service\ViewModels\ServiceViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
