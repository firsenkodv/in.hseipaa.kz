<?php

namespace App\Http\Controllers\HeadHunter\HunterVacancy;

use App\Http\Controllers\Controller;
use App\Http\Requests\HH\Vacancy\StoreVacancyRequest;
use App\Http\Requests\HH\Vacancy\UpdateVacancyRequest;
use Domain\City\ViewModels\CityViewModel;
use Domain\HH\Vacancy\DTOs\StoreVacancyDto;
use Domain\HH\Vacancy\ViewModel\VacancyViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserVacancyController extends Controller
{

    /**
     * Список активных вакансий текущего пользователя (личный кабинет).
     * Данные: вакансии авторизованного пользователя, не находящиеся в архиве.
     * Результат: шаблон hh/hunter_vacancy/user/index.
     */
    public function index(): View
    {
        try {
            $user  = UserViewModel::make()->User();
            $items = VacancyViewModel::make()->userVacancies($user->id);

            return view('hh.hunter_vacancy.user.index', compact('user', 'items'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Страница одной вакансии в личном кабинете пользователя.
     * Данные: вакансия берётся по ID и проверяется принадлежность текущему пользователю.
     * Показывает как опубликованные, так и неопубликованные вакансии (но не чужие).
     * Результат: шаблон hh/hunter_vacancy/user/show.
     */
    public function show($id): View
    {
        try {
            $user = UserViewModel::make()->User();
            $item = VacancyViewModel::make()->userVacancy((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            return view('hh.hunter_vacancy.user.show', compact('user', 'item'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }


    /**
     * Страница формы создания новой вакансии (GET).
     * Данные: загружаются категории, города и варианты опыта работы для полей select.
     * Также передаётся текущий пользователь для предзаполнения контактных данных.
     * Результат: шаблон hh/hunter_vacancy/user/store.
     */
    public function store(): View
    {
        try {
            $user        = UserViewModel::make()->User();
            $categories  = VacancyViewModel::make()->categories()->toArray();
            $cities      = CityViewModel::make()->Cities()->toArray();
            $experiences = VacancyViewModel::make()->experiences()->toArray();

            return view('hh.hunter_vacancy.user.store', compact('user', 'categories', 'cities', 'experiences'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }
    /**
     * Страница формы редактирования вакансии (GET).
     * Данные: вакансия берётся по ID с проверкой принадлежности пользователю.
     * Загружаются категории, города и варианты опыта для select-полей.
     * Результат: шаблон hh/hunter_vacancy/user/update с предзаполненными данными.
     */
    public function update($id): View
    {
        try {
            $user        = UserViewModel::make()->User();
            $item        = VacancyViewModel::make()->userVacancy((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            $categories  = VacancyViewModel::make()->categories()->toArray();
            $cities      = CityViewModel::make()->Cities()->toArray();
            $experiences = VacancyViewModel::make()->experiences()->toArray();

            return view('hh.hunter_vacancy.user.update', compact('item', 'user', 'categories', 'cities', 'experiences'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Сохранение изменений вакансии в базу данных (PUT).
     * Данные: приходят из формы редактирования, валидируются через UpdateVacancyRequest.
     * При наличии нового логотипа — старый удаляется, новый сохраняется.
     * Результат: редирект на страницу вакансии с flash-сообщением об успехе или ошибке.
     */
    public function updateSave(UpdateVacancyRequest $request, $id): RedirectResponse
    {


        try {
            $user       = UserViewModel::make()->User();
            $dto        = StoreVacancyDto::make(...$request->only(StoreVacancyDto::FIELDS));
            $logo       = $request->hasFile('logo') ? $request->file('logo') : null;
            $removeLogo = $request->input('remove_logo') === '1';

            VacancyViewModel::make()->update((int) $id, $user->id, $dto, $logo, $removeLogo);

            flash()->info(config('message_flash.info.vacancy_update_ok'));

            return redirect()->route('my_vacancy_edit', $id);

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.vacancy_update_error'));

            return redirect()->back()->withInput();
        }
    }
    /**
     * Сохранение новой вакансии в базу данных (POST).
     * Данные: приходят из формы создания, валидируются через StoreVacancyRequest.
     * Формируется DTO, при наличии — сохраняется логотип. Вакансия сохраняется как неопубликованная.
     * Результат: редирект на список «Мои вакансии» с flash-сообщением об успехе или ошибке.
     */
    public function save(StoreVacancyRequest $request): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            $dto  = StoreVacancyDto::formRequest($request);
            $logo = $request->hasFile('logo') ? $request->file('logo') : null;

            VacancyViewModel::make()->create($dto, $user->id, $logo);

            flash()->info(config('message_flash.info.vacancy_create_ok'));

            return redirect()->route('my_vacancies');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.vacancy_create_error'));

            return redirect()->back()->withInput();
        }
    }

    /**
     * Список архивных вакансий текущего пользователя.
     * Данные: вакансии авторизованного пользователя со статусом archive = ARCHIVE.
     * Результат: шаблон hh/hunter_vacancy/user/archive.
     */
    public function archive(): View
    {
        try {
            $user  = UserViewModel::make()->User();
            $items = VacancyViewModel::make()->userVacanciesArchive($user->id);

            return view('hh.hunter_vacancy.user.archive', compact('user', 'items'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Страница одной архивной вакансии текущего пользователя.
     * Данные: вакансия берётся по ID, проверяется принадлежность пользователю и статус archive = ARCHIVE.
     * Результат: шаблон hh/hunter_vacancy/user/archive_show.
     */
    public function archiveShow($id): View
    {
        try {
            $user = UserViewModel::make()->User();
            $item = VacancyViewModel::make()->userVacancyArchive((int) $id, $user->id);

            if (!$item) {
                abort(404);
            }

            return view('hh.hunter_vacancy.user.archive_show', compact('user', 'item'));

        } catch (\Throwable $th) {
            logErrors($th);
            abort(404);
        }
    }

    /**
     * Восстановление вакансии из архива (POST).
     * Данные: ID вакансии из URL, принадлежность проверяется по user_id.
     * Устанавливает archive = NOTARCHIVED и продлевает expired_at на 30 дней. Статус публикации не меняется.
     * Результат: редирект на страницу вакансии в «Мои вакансии» с flash-сообщением.
     */
    public function restore($id): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            VacancyViewModel::make()->restoreFromArchive((int) $id, $user->id);

            flash()->info(config('message_flash.info.vacancy_restore_ok'));

            return redirect()->route('my_vacancy', $id);

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.vacancy_restore_error'));

            return redirect()->back();
        }
    }

    /**
     * Перемещение вакансии пользователя в архив (POST).
     * Данные: ID вакансии из URL, принадлежность проверяется по user_id.
     * Устанавливает archive = ARCHIVE, модель автоматически снимает публикацию через boot().
     * Результат: редирект на список архивных вакансий с flash-сообщением.
     */
    public function archive_move($id): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            VacancyViewModel::make()->moveToArchive((int) $id, $user->id);

            flash()->info(config('message_flash.info.vacancy_archive_ok'));

            return redirect()->route('my_vacancy_archive');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.vacancy_archive_error'));

            return redirect()->back();
        }
    }

    /**
     * Удаление вакансии пользователя (DELETE).
     * Данные: ID вакансии из URL, принадлежность проверяется по user_id перед удалением.
     * Запись удаляется из базы данных безвозвратно.
     * Результат: редирект на список «Мои вакансии» с flash-сообщением.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $user = UserViewModel::make()->User();
            VacancyViewModel::make()->delete((int) $id, $user->id);

            flash()->info(config('message_flash.info.vacancy_delete_ok'));

            return redirect()->route('my_vacancies');

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.vacancy_delete_error'));

            return redirect()->back();
        }
    }


}
