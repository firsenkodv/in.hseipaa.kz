<?php

namespace App\Http\Controllers\Cabinet\CabinetUser;

use App\Http\Controllers\Controller;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CabinetUserController extends Controller
{
    public function cabinetUser():View
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

}
