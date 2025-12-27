<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class SignInController extends Controller
{

    public function login():View
    {
      //  dd('login');
        return view('auth.login');
    }



    public function handleLogin(SignInFormRequest $request): RedirectResponse
    {

        if (!auth()->attempt($request->validated()))
        {
            return back()->withErrors([
                'email' => 'Ошибка в поле E-mail или пароль',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('cabinet_user')); // intended - назад или route
    }





}
