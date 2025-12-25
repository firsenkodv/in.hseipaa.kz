<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use App\Models\User;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class SignUpController extends Controller
{
    public function signUp(): View
    {

        dd('signUp');
        return view('auth.sign_up');

    }

    public function handleSignUp(SignUpFormRequest $request): RedirectResponse
    {

        try {

            $user = UserViewModel::make()->UserCreate($request->all());
            auth()->login($user, true); // залогинили
            flash()->info(config('message_flash.info.sign_up_ok'));
            return redirect()->route('cabinet_user');

        } catch (\Throwable $th) {

            // Обрабатываем исключение
            logErrors($th);
            flash()->alert(config('message_flash.alert.sign_up_error'));
            return redirect()->back();

        }

    }

}
