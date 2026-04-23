<?php

namespace App\Http\Controllers\HeadHunter\HunterResume;

use App\Http\Controllers\Controller;
use App\Http\Requests\HH\Resume\StoreResumeRequest;
use App\Http\Requests\HH\Resume\UpdateResumeRequest;
use Domain\City\ViewModels\CityViewModel;
use Domain\HH\Resume\DTOs\StoreResumeDto;
use Domain\HH\Resume\ViewModel\ResumeViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserResumeController extends Controller
{

    /**
     * Список активных резюме текущего пользователя (личный кабинет).
     * Данные: резюме авторизованного пользователя, не находящиеся в архиве.
     * Результат: шаблон hh/hunter_resume/user/index.
     */
    public function index(): View
    {
        try {
            $user  = UserViewModel::make()->User();
            $items = ResumeViewModel::make()->userResumes($user->id);

            return view('hh.hunter_resume.user.index', compact('user', 'items'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Страница одного резюме в личном кабинете пользователя.
     * Данные: резюме берётся по ID и проверяется принадлежность текущему пользователю.
     * Показывает как опубликованные, так и неопубликованные резюме (но не чужие).
     * Результат: шаблон hh/hunter_resume/user/show.
     */
    public function show($id): View
    {
        try {
            $user = UserViewModel::make()->User();
            $item = ResumeViewModel::make()->userResume((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            return view('hh.hunter_resume.user.show', compact('item', 'user'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


    /**
     * Страница формы создания нового резюме (GET).
     * Данные: загружаются категории, города и варианты опыта работы для полей select.
     * Также передаётся текущий пользователь для предзаполнения контактных данных.
     * Результат: шаблон hh/hunter_resume/user/store.
     */
    public function store(): View
    {
        try {
            $user        = UserViewModel::make()->User();
            $categories  = ResumeViewModel::make()->categories()->toArray();
            $cities      = CityViewModel::make()->Cities()->toArray();
            $experiences = ResumeViewModel::make()->experiences()->toArray();

            return view('hh.hunter_resume.user.store', compact('user', 'categories', 'cities', 'experiences'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Сохранение нового резюме в базу данных (POST).
     * Данные: приходят из формы создания, валидируются через StoreResumeRequest.
     * Формируется DTO, резюме сохраняется как неопубликованное с датой истечения +30 дней.
     * Результат: редирект на список «Мои резюме» с flash-сообщением об успехе или ошибке.
     */
    public function save(StoreResumeRequest $request): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            $dto  = StoreResumeDto::formRequest($request);

            ResumeViewModel::make()->create($dto, $user->id);

            flash()->info(config('message_flash.info.resume_create_ok'));

            return redirect()->route('my_resumes');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.resume_create_error'));

            return redirect()->back()->withInput();
        }
    }

    /**
     * Страница формы редактирования резюме (GET).
     * Данные: загружаются категории, города и варианты опыта работы для select.
     * Резюме берётся по ID с проверкой принадлежности пользователю.
     * Результат: шаблон hh/hunter_resume/user/update.
     */
    public function update($id): View
    {
        try {
            $user        = UserViewModel::make()->User();
            $item        = ResumeViewModel::make()->userResume((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            $categories  = ResumeViewModel::make()->categories()->toArray();
            $cities      = CityViewModel::make()->Cities()->toArray();
            $experiences = ResumeViewModel::make()->experiences()->toArray();

            return view('hh.hunter_resume.user.update', compact('user', 'item', 'categories', 'cities', 'experiences'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Сохранение изменений резюме (PUT).
     * Данные: приходят из формы редактирования, валидируются через UpdateResumeRequest.
     * Результат: редирект на страницу редактирования с flash-сообщением.
     */
    public function updateSave(UpdateResumeRequest $request, $id): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            $dto  = StoreResumeDto::make(...$request->only(StoreResumeDto::FIELDS));

            ResumeViewModel::make()->update((int) $id, $user->id, $dto);

            flash()->info(config('message_flash.info.resume_update_ok'));

            return redirect()->route('my_resume_edit', $id);

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.resume_update_error'));

            return redirect()->back()->withInput();
        }
    }

    /**
     * Список архивных резюме текущего пользователя.
     * Данные: резюме авторизованного пользователя со статусом archive = ARCHIVE.
     * Результат: шаблон hh/hunter_resume/user/archive.
     */
    public function archive(): View
    {
        try {
            $user  = UserViewModel::make()->User();
            $items = ResumeViewModel::make()->userResumesArchive($user->id);

            return view('hh.hunter_resume.user.archive', compact('user', 'items'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Страница одного архивного резюме текущего пользователя.
     * Данные: резюме берётся по ID, проверяется принадлежность пользователю и статус archive = ARCHIVE.
     * Результат: шаблон hh/hunter_resume/user/archive_show.
     */
    public function archiveShow($id): View
    {
        try {
            $user = UserViewModel::make()->User();
            $item = ResumeViewModel::make()->userResumeArchive((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            return view('hh.hunter_resume.user.archive_show', compact('user', 'item'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Перемещение резюме пользователя в архив (POST).
     * Данные: ID резюме из URL, принадлежность проверяется по user_id.
     * Устанавливает archive = ARCHIVE, модель автоматически снимает публикацию через boot().
     * Результат: редирект на список архивных резюме с flash-сообщением.
     */
    public function archive_move($id): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            ResumeViewModel::make()->moveToArchive((int) $id, $user->id);

            flash()->info(config('message_flash.info.resume_archive_ok'));

            return redirect()->route('my_resume_archive');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.resume_archive_error'));

            return redirect()->back();
        }
    }

    /**
     * Восстановление резюме из архива (POST).
     * Данные: ID резюме из URL, принадлежность проверяется по user_id.
     * Устанавливает archive = NOTARCHIVED и продлевает expired_at на 30 дней. Статус публикации не меняется.
     * Результат: редирект на страницу резюме в «Мои резюме» с flash-сообщением.
     */
    public function restore($id): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            ResumeViewModel::make()->restoreFromArchive((int) $id, $user->id);

            flash()->info(config('message_flash.info.resume_restore_ok'));

            return redirect()->route('my_resume', $id);

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.resume_restore_error'));

            return redirect()->back();
        }
    }

    /**
     * Удаление резюме пользователя (DELETE).
     * Данные: ID резюме из URL, принадлежность проверяется по user_id перед удалением.
     * Запись удаляется из базы данных безвозвратно.
     * Результат: редирект на список «Мои резюме» с flash-сообщением.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            ResumeViewModel::make()->delete((int) $id, $user->id);

            flash()->info(config('message_flash.info.resume_delete_ok'));

            return redirect()->route('my_resumes');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.resume_delete_error'));

            return redirect()->back();
        }
    }


}
