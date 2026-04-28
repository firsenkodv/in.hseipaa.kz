<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\ForgotPasswordEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        $forgot = false;
        if (session('forgot')) {
            $forgot = true;
            session()->forget('forgot');
        }

        return view('auth.forgot-password', ['forgot' => $forgot]);
    }

    public function handleForgot(ForgotPasswordFormRequest $request): RedirectResponse
    {
        $broker = app(PasswordBrokerManager::class)->broker();
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors(['email' => config('message_flash.alert.user_not_found')]);
        }

        $token = $broker->createToken($user);

        ForgotPasswordEvent::dispatch([
            'email' => $user->email,
            'token' => $token,
        ]);

        flash()->info(config('message_flash.info.password_reset_link_sent'));

        session(['forgot' => 1]);
        return redirect()->route('forgot');
    }
}
