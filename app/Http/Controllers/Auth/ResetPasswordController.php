<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function page(Request $request, string $token): View|RedirectResponse
    {
        $email = $request->query('email');

        if (!$email) {
            flash()->alert(config('message_flash.alert.password_reset_no_email'));
            return redirect()->route('forgot');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash()->alert(config('message_flash.alert.password_reset_no_correct_email'));
            return redirect()->route('forgot');
        }

        $broker = Password::broker();
        $user = $broker->getUser(['email' => $email]);

        if (!$user) {
            return redirect()->route('forgot');
        }

        if (!$broker->tokenExists($user, $token)) {
            flash()->alert(config('message_flash.alert.password_reset_error'));
            return redirect()->route('forgot');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function handle(ResetPasswordFormRequest $request): RedirectResponse
    {
        $status = Password::reset(
            [
                'email'                 => $request['email'],
                'password'              => $request['password'],
                'password_confirmation' => $request['password_confirmation'],
                'token'                 => $request['token'],
            ],
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            flash()->info(config('message_flash.info.password_reset_ok'));
            return redirect()->route('login');
        }

        $errors = match ($status) {
            Password::INVALID_TOKEN   => ['token' => 'Недействительный токен сброса пароля.'],
            Password::INVALID_USER    => ['email' => 'Пользователь с таким email не найден.'],
            Password::RESET_THROTTLED => ['email' => 'Слишком много попыток. Попробуйте позже.'],
            default                   => ['email' => 'Произошла ошибка при сбросе пароля.'],
        };

        return back()->withErrors($errors);
    }
}
