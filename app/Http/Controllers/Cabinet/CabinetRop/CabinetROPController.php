<?php

namespace App\Http\Controllers\Cabinet\CabinetRop;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetRop\ManagerUpdateRequest;
use App\Http\Requests\CabinetRop\RopUpdateRequest;
use App\Http\Requests\CabinetUser\UserUpdateRequest;
use Domain\Manager\DTOs\ManagerUpdateDto;
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

    public function ropLogin()
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
            $r = ROPViewModel::make()->r(session()->get('r'));
            ManagerViewModel::make()->updatePersonalDataManager($request, $r->id);
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
    public function ropUsers() {

        $r = ROPViewModel::make()->r(session()->get('r'));
        $users = ROPViewModel::make()->ropUserList($r);
        $managers = ROPViewModel::make()->ropManagerList($r);

        return view('cabinet.cabinet_rop.users.items', [
            'r' => $r,
            'users' => $users,
            'managers' => $managers,
        ]);

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
