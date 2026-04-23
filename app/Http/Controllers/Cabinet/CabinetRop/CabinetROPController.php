<?php

namespace App\Http\Controllers\Cabinet\CabinetRop;

use App\Enums\User\MarkedDeleteEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetRop\ManagerAddRequest;
use App\Http\Requests\CabinetRop\ManagerUpdateRequest;
use App\Http\Requests\CabinetRop\RopUpdateRequest;
use App\Http\Requests\CabinetRop\UserAssignRequest;
use App\Http\Requests\CabinetUser\UserUpdateRequest;
use App\Models\User;
use Domain\HH\Resume\ViewModel\ResumeViewModel;
use Domain\HH\Vacancy\ViewModel\VacancyViewModel;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Support\Traits\Upload;

class CabinetROPController extends Controller
{
    use Upload;

    public function ropLogin():View
    {

        return view('cabinet.cabinet_rop.auth.login_rop');

    }

    public function ropLoginHandle(Request $request):View|RedirectResponse
    {
        /** удалим сессию ***/
        session()->forget('r_email');
        session()->forget('r_password');

        $ROP = ROPViewModel::make()->ROP($request);

        if (is_null($ROP)) {
            flash()->alert(config('message_flash.alert.__enter_error'));
            /** запустим сессию***/
            session(['r_email' => $request->email, 'r_password' => $request->password]); // запустим сессию
            return redirect(route('rop_login'));
        } else {

            session()->forget('m');
            session(['r' => $request->email]); // запустим сессию
            return redirect(route('cabinet_rop'));
        }

    }


    /**
     * Вход в кабинет РОП
     */
    public function cabinetRop():View|RedirectResponse
    {

        $r = ROPViewModel::make()->r(session()->get('r'));

        if (is_null($r)) {
            flash()->alert(config('message_flash.alert.__enter_error'));
            return redirect(route('rop_login'));
        }

        return view('cabinet.cabinet_rop.cabinet_rop', ['r' => $r]);

    }

    /**
     * Выход  из кабинета РОП
     */
    public function logoutRop():RedirectResponse
    {
        if (session()->exists('r')) {
            /** удалим сесиию ***/
            session()->forget('r');
            flash()->info(config('message_flash.info.__good_exit'));
            return redirect(route('rop_login'));
        }

        flash()->alert(config('message_flash.alert.role_error'));
        return redirect(route('rop_login'));

    }

    /**
     * update
     */
    public function cabinetUpdatePersonalDataRop()
    {
        $r = ROPViewModel::make()->r(session()->get('r'));
        if(!$r) {
            abort(404);
        }
        return view('cabinet.cabinet_rop.cabinet_rop_update', ['r' => $r]);


    }

    /**
     * @param RopUpdateRequest $request
     * @return RedirectResponse
     * DTO - Data Transfer Object внутри ROPViewModel
     */

    public function cabinetUpdatePostPersonalDataRop(RopUpdateRequest $request):RedirectResponse
    {
        try {
            $r = ROPViewModel::make()->r(session()->get('r'));
            ROPViewModel::make()->updatePersonalDataRop($request, $r->id);
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
     * список менеджеров
     */
    public function ropManagers():View
    {
        $r = ROPViewModel::make()->r(session()->get('r'));
        $items = ROPViewModel::make()->ropManagerListPaginate($r);

        return view('cabinet.cabinet_rop.managers.items', [
            'r' => $r,
            'items' => $items,
        ]);


    }

    /**
     * Редактирование менеджера
     */
    public function ropUpdateManager($id):View
    {
        $r = ROPViewModel::make()->r(session()->get('r'));
        $item = ROPViewModel::make()->ropManagerId($id, $r->id);

        return view('cabinet.cabinet_rop.managers.item', [
            'r' => $r,
            'item' => $item,
        ]);
    }

    /**
     * Редактирование менеджера
     * метод POST
     */
    public function ropUpdatePostManager(ManagerUpdateRequest $request):RedirectResponse
    {
        try {

            ManagerViewModel::make()->updatePersonalDataManager($request);
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
     * Создание менеджера
     */
    public function ropAddManager():View
    {
        $r = ROPViewModel::make()->r(session()->get('r'));
        return view('cabinet.cabinet_rop.managers.add.add_manager', [
            'r' => $r,
        ]);

    }

    /**
     * Создание менеджера
     */
    public function ropAddPostManager(ManagerAddRequest $request):RedirectResponse
    {
        try {
            $r = ROPViewModel::make()->r(session()->get('r'));
            $request->merge(['r_o_p_id' => $r->id]);
            $manager = ManagerViewModel::make()->addPersonalDataManager($request);
            flash()->info(config('message_flash.info.cabinet_user_ok'));
            return redirect()->route('rop_update_manager', $manager->id);

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            flash()->alert(config('message_flash.alert.cabinet_user_error'));
            return redirect()->back();

        }

    }

    /**
     * управление клиентами
     * спискок
     */
    public function ropUsers():View
    {

        $r = ROPViewModel::make()->r(session()->get('r'));
        $users = ROPViewModel::make()->ropUserList($r);
        $managers = ROPViewModel::make()->ropManagerListMap($r);

        return view('cabinet.cabinet_rop.users.items', [
            'r' => $r,
            'users' => $users,
            'managers' => $managers,
        ]);

    }

    /**
     * управление клиентами
     * спискок заблокированных
     */
    public function ropNoPublishedUsers():View
    {

        $r = ROPViewModel::make()->r(session()->get('r'));
        $users = ROPViewModel::make()->ropUserList($r, 'locked');
        $managers = ROPViewModel::make()->ropManagerListMap($r);

        return view('cabinet.cabinet_rop.users.items', [
            'r'          => $r,
            'users'      => $users,
            'managers'   => $managers,
            'markDelete' => true,
        ]);

    }

    /**
     * Список пользователей, отмеченных на удаление
     */
    public function ropDeletedUsers(): View
    {
        $r = ROPViewModel::make()->r(session()->get('r'));
        $users = ROPViewModel::make()->ropUserList($r, 'deleted');
        $managers = ROPViewModel::make()->ropManagerListMap($r);

        return view('cabinet.cabinet_rop.users.items', [
            'r'        => $r,
            'users'    => $users,
            'managers' => $managers,
        ]);
    }

    /**
     * Отметить пользователя на удаление
     */
    public function ropMarkUserForDelete(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->marked_delete = MarkedDeleteEnum::MARKED->value;
        $user->save();

        return redirect()->back();
    }

    /** Поиск пользователей */
    public function ropUsersSearch(Request $request)
    {

        //dd($request->all());

        $r = ROPViewModel::make()->r(session()->get('r'));
        $users = ROPViewModel::make()->ropUserListSearch($request->id);
        $managers = ROPViewModel::make()->ropManagerListMap($r);
        $manager_selected = ManagerViewModel::make()->managerId($request->id);


        return view('cabinet.cabinet_rop.users.items', [
            'r' => $r,
            'users' => $users,
            'managers' => $managers,
            'manager_selected' => $manager_selected->username,
            'manager_value' => $manager_selected->id,
        ]);

    }

    /** Закрепление пользователя за менеджером */
    public function ropUsersAssign(UserAssignRequest $request)
    {
        try {
       ManagerViewModel::make()->assignUsers($request->id, $request->users);
        flash()->info(config('message_flash.info.cabinet_user_ok'));
        return redirect()->route('rop_users');
        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            flash()->alert(config('message_flash.alert.cabinet_user_error'));
            return redirect()->back();

        }

    }



    /**
     * Опубликовать вакансию (published = 1).
     */
    public function ropHhVacancyPublish(int $id): RedirectResponse
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterVacancyItem::query()
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        $item->published = 1;
        $item->save();

        return redirect()->route('rop_hh_vacancy', $id);
    }

    /**
     * Заблокировать вакансию (published = 0).
     */
    public function ropHhVacancyUnpublish(int $id): RedirectResponse
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterVacancyItem::query()
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        $item->published = 0;
        $item->save();

        return redirect()->route('rop_hh_vacancy_moder', $id);
    }

    /**
     * Страница просмотра вакансии из общего списка.
     */
    public function ropHhVacancy(int $id): View
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterVacancyItem::query()
            ->with(['user', 'category', 'city', 'experience'])
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        return view('cabinet.cabinet_rop.hh.vacancy', [
            'r'          => $r,
            'item'       => $item,
            'breadcrumb' => 'rop_hh_vacancy',
        ]);
    }

    /**
     * Страница просмотра вакансии из списка на модерации.
     */
    public function ropHhVacancyModer(int $id): View
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterVacancyItem::query()
            ->with(['user', 'category', 'city', 'experience'])
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        return view('cabinet.cabinet_rop.hh.vacancy', [
            'r'          => $r,
            'item'       => $item,
            'breadcrumb' => 'rop_hh_vacancy_moder',
        ]);
    }

    /**
     * Список всех вакансий пользователей РОП с фильтрацией по городу и категории.
     * Иерархия: РОП → менеджеры → пользователи → вакансии.
     */
    public function ropHhVacancies(Request $request): View
    {
        $r          = ROPViewModel::make()->r(session()->get('r'));
        $cityId     = (int) $request->input('city')     ?: null;
        $categoryId = (int) $request->input('category') ?: null;
        $cities     = ROPViewModel::make()->ropVacancyCities($r);
        $categories = select(VacancyViewModel::make()->categories());
        $items      = ROPViewModel::make()->ropVacancyList($r, false, $cityId, $categoryId);
        $fields     = $this->buildVacancyFields($cityId, $categoryId, $cities, $categories);

        return view('cabinet.cabinet_rop.hh.vacancies', compact('r', 'items', 'cities', 'categories', 'fields'));
    }

    /**
     * Список неопубликованных вакансий пользователей РОП (на модерации) с фильтрами.
     */
    public function ropHhVacanciesModer(Request $request): View
    {
        $r          = ROPViewModel::make()->r(session()->get('r'));
        $cityId     = (int) $request->input('city')     ?: null;
        $categoryId = (int) $request->input('category') ?: null;
        $cities     = ROPViewModel::make()->ropVacancyCities($r, true);
        $categories = select(VacancyViewModel::make()->categories());
        $items      = ROPViewModel::make()->ropVacancyList($r, true, $cityId, $categoryId);
        $fields     = $this->buildVacancyFields($cityId, $categoryId, $cities, $categories);

        return view('cabinet.cabinet_rop.hh.vacancies', compact('r', 'items', 'cities', 'categories', 'fields'));
    }

    /**
     * Формирует массив полей фильтра для передачи в шаблон вакансий.
     */
    private function buildVacancyFields(?int $cityId, ?int $categoryId, array $cities, array $categories): array
    {
        return [
            'city'     => $cityId     ? ['id' => $cityId,     'title' => collect($cities)->firstWhere('id', $cityId)['title']         ?? ''] : null,
            'category' => $categoryId ? ['id' => $categoryId, 'title' => collect($categories)->firstWhere('id', $categoryId)['title']  ?? ''] : null,
        ];
    }

    /**
     * Опубликовать резюме (published = 1).
     */
    public function ropHhResumePublish(int $id): RedirectResponse
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterResumeItem::query()
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        $item->published = 1;
        $item->save();

        return redirect()->route('rop_hh_resume', $id);
    }

    /**
     * Заблокировать резюме (published = 0).
     */
    public function ropHhResumeUnpublish(int $id): RedirectResponse
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterResumeItem::query()
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        $item->published = 0;
        $item->save();

        return redirect()->route('rop_hh_resume_moder', $id);
    }

    /**
     * Страница просмотра резюме из общего списка.
     */
    public function ropHhResume(int $id): View
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterResumeItem::query()
            ->with(['user', 'category', 'city', 'experience'])
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        return view('cabinet.cabinet_rop.hh.resume', [
            'r'          => $r,
            'item'       => $item,
            'breadcrumb' => 'rop_hh_resume',
        ]);
    }

    /**
     * Страница просмотра резюме из списка на модерации.
     */
    public function ropHhResumeModer(int $id): View
    {
        $r       = ROPViewModel::make()->r(session()->get('r'));
        $userIds = ROPViewModel::make()->ropUserIds($r);

        $item = \App\Models\HunterResumeItem::query()
            ->with(['user', 'category', 'city', 'experience'])
            ->whereIn('user_id', $userIds)
            ->findOrFail($id);

        return view('cabinet.cabinet_rop.hh.resume', [
            'r'          => $r,
            'item'       => $item,
            'breadcrumb' => 'rop_hh_resume_moder',
        ]);
    }

    /**
     * Список всех резюме пользователей РОП с фильтрацией по городу и категории.
     * Иерархия: РОП → менеджеры → пользователи → резюме.
     */
    public function ropHhResumes(Request $request): View
    {
        $r          = ROPViewModel::make()->r(session()->get('r'));
        $cityId     = (int) $request->input('city')     ?: null;
        $categoryId = (int) $request->input('category') ?: null;
        $cities     = ROPViewModel::make()->ropResumeCities($r);
        $categories = select(ResumeViewModel::make()->categories());
        $items      = ROPViewModel::make()->ropResumeList($r, false, $cityId, $categoryId);
        $fields     = $this->buildResumeFields($cityId, $categoryId, $cities, $categories);

        return view('cabinet.cabinet_rop.hh.resumes', compact('r', 'items', 'cities', 'categories', 'fields'));
    }

    /**
     * Список неопубликованных резюме пользователей РОП (на модерации) с фильтрами.
     */
    public function ropHhResumesModer(Request $request): View
    {
        $r          = ROPViewModel::make()->r(session()->get('r'));
        $cityId     = (int) $request->input('city')     ?: null;
        $categoryId = (int) $request->input('category') ?: null;
        $cities     = ROPViewModel::make()->ropResumeCities($r, true);
        $categories = select(ResumeViewModel::make()->categories());
        $items      = ROPViewModel::make()->ropResumeList($r, true, $cityId, $categoryId);
        $fields     = $this->buildResumeFields($cityId, $categoryId, $cities, $categories);

        return view('cabinet.cabinet_rop.hh.resumes', compact('r', 'items', 'cities', 'categories', 'fields'));
    }

    /**
     * Формирует массив полей фильтра для передачи в шаблон резюме.
     */
    private function buildResumeFields(?int $cityId, ?int $categoryId, array $cities, array $categories): array
    {
        return [
            'city'     => $cityId     ? ['id' => $cityId,     'title' => collect($cities)->firstWhere('id', $cityId)['title']         ?? ''] : null,
            'category' => $categoryId ? ['id' => $categoryId, 'title' => collect($categories)->firstWhere('id', $categoryId)['title']  ?? ''] : null,
        ];
    }

    /**
     * Редактирование пользователя
     */
    public function ropUpdateUser($id)
    {
        $r = ROPViewModel::make()->r(session()->get('r'));
        $user = ROPViewModel::make()->ropUserId($id, $r->id);

        return view('cabinet.cabinet_rop.users.item', [
            'r' => $r,
            'user' => $user,
        ]);
    }


    /**
     * Редактирование пользователя
     * метод POST
     */
    public function ropUpdatePostUser(UserUpdateRequest $request):RedirectResponse
    {
        try {
            UserViewModel::make()->UserUpdate($request, $request->id);
            flash()->info(config('message_flash.info.cabinet_user_ok'));
            return redirect()->back();

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            flash()->alert(config('message_flash.alert.cabinet_user_error'));
            return redirect()->back();

        }
    }


}
