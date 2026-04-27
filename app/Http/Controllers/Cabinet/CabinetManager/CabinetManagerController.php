<?php

namespace App\Http\Controllers\Cabinet\CabinetManager;

use App\Enums\User\MarkedDeleteEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetManager\ManagerUpdateRequest;
use App\Http\Requests\CabinetUser\UserUpdateRequest;
use App\Models\User;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CabinetManagerController extends Controller
{

    public function managerLogin()
    {
        return view('cabinet.cabinet_manager.auth.login_manager');

    }

    public function managerLoginHandle(Request $request): View|RedirectResponse
    {
        /** удалим сессию ***/
        session()->forget('m_email');
        session()->forget('m_password');

        $manager = ManagerViewModel::make()->manager($request);

        if (is_null($manager)) {
            flash()->alert(config('message_flash.alert.__enter_error'));
            /** запустим сессию***/
            session(['m_email' => $request->email, 'm_password' => $request->password]); // запустим сессию
            return redirect(route('manager_login'));
        } else {

            session()->forget('r');
            session(['m' => $request->email]); // запустим сессию
            return redirect(route('cabinet_manager'));
        }
    }

    /**
     * Вход в кабинет Manager
     */
    public function cabinetManager(): View|RedirectResponse
    {

        $m = ManagerViewModel::make()->m(session()->get('m'));

        if (is_null($m)) {
            flash()->alert(config('message_flash.alert.__enter_error'));
            return redirect(route('manager_login'));
        }

        return view('cabinet.cabinet_manager.cabinet_manager', ['m' => $m]);

    }

    /**
     * update
     */
    public function cabinetUpdatePersonalDataManager()
    {
        $m = ManagerViewModel::make()->m(session()->get('m'));
        if(!$m) {
            abort(404);
        }
        return view('cabinet.cabinet_manager.cabinet_manager_update', ['m' => $m]);


    }

    /**
     * @param ManagerUpdateRequest $request
     * @return RedirectResponse
     * DTO - Data Transfer Object внутри ManagerViewModel
     */

    public function cabinetUpdatePostPersonalDataManager(ManagerUpdateRequest $request):RedirectResponse
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
     * управление клиентами
     * спискок
     */
    public function managerUsers(): View
    {
        $m = ManagerViewModel::make()->m(session()->get('m'));
        $users = ManagerViewModel::make()->managerUserList($m);

        return view('cabinet.cabinet_manager.users.items', [
            'm'     => $m,
            'users' => $users,
        ]);
    }

    public function managerNoPublishedUsers(): View
    {
        $m = ManagerViewModel::make()->m(session()->get('m'));
        $users = ManagerViewModel::make()->managerUserList($m, 'locked');

        return view('cabinet.cabinet_manager.users.items', [
            'm'          => $m,
            'users'      => $users,
            'markDelete' => true,
        ]);
    }

    public function managerDeletedUsers(): View
    {
        $m = ManagerViewModel::make()->m(session()->get('m'));
        $users = ManagerViewModel::make()->managerUserList($m, 'deleted');

        return view('cabinet.cabinet_manager.users.items', [
            'm'     => $m,
            'users' => $users,
        ]);
    }

    public function managerSetUserTarif(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $user = User::findOrFail((int) $request->user_id);
        $tarifId = (int) $request->tarif_id ?: null;
        $user->tarif_id = $tarifId;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json(['response' => ['tarif_id' => $tarifId]], 200);
        }

        flash()->info(config('message_flash.info.cabinet_user_ok'));
        return redirect()->back();
    }

    public function managerMarkUserForDelete(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->marked_delete = MarkedDeleteEnum::MARKED->value;
        $user->save();

        return redirect()->back();
    }

    public function managerUsersSearch(Request $request): View
    {
        $m      = ManagerViewModel::make()->m(session()->get('m'));
        $search = trim($request->input('search', ''));
        $roles  = $request->input('roles', []);
        $users  = ManagerViewModel::make()->managerUserList($m, '', $search, $roles);

        return view('cabinet.cabinet_manager.users.items', [
            'm'      => $m,
            'users'  => $users,
            'search' => $search,
            'roles'  => $roles,
        ]);
    }

    public function managerUpdateUser(int $id): View
    {
        $m = ManagerViewModel::make()->m(session()->get('m'));
        $user = ManagerViewModel::make()->managerUserId($id, $m->id);

        return view('cabinet.cabinet_manager.users.item', [
            'm'    => $m,
            'user' => $user,
        ]);
    }

    public function managerUpdatePostUser(UserUpdateRequest $request): RedirectResponse
    {
        try {
            UserViewModel::make()->UserUpdate($request, $request->id);
            flash()->info(config('message_flash.info.cabinet_user_ok'));
            return redirect()->back();

        } catch (\Throwable $th) {
            logErrors($th);
            flash()->alert(config('message_flash.alert.cabinet_user_error'));
            return redirect()->back();
        }
    }


    /**
     * Выход из кабинета manager
     */
    public function logoutManager(): RedirectResponse
    {
        if (session()->exists('m')) {
            /** удалим сесиию ***/
            session()->forget('m');
            flash()->info(config('message_flash.info.__good_exit'));
            return redirect(route('manager_login'));
        }

        flash()->alert(config('message_flash.alert.role_error'));
        return redirect(route('manager_login'));

    }


}
