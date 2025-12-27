<?php

namespace App\Http\Controllers\Cabinet\CabinetUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabinetUser\UserUpdateRequest;
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


           // dd(idn_to_utf8('xn--24-6kcdtb9axj4gqa.xn--p1ai'));
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
     * @param Request $request
     * Метод редактирования User
     */
//: RedirectResponse
    public function cabinetUserUpdateHandel(UserUpdateRequest $request)
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

}
