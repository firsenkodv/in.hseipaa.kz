<?php

namespace App\Auth;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JoomlaUserProvider extends EloquentUserProvider
{
    private ?object $pendingJoomlaUser = null;

    /**
     * Ищем пользователя: сначала в таблице users, потом в pc0ec_users (Joomla).
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $user = parent::retrieveByCredentials($credentials);

        if ($user) {
            $this->pendingJoomlaUser = null;
            return $user;
        }

        $email = $credentials['email'] ?? null;
        if (!$email) {
            return null;
        }

        $joomlaUser = DB::table('pc0ec_users')->where('email', $email)->first();
        if (!$joomlaUser) {
            return null;
        }

        // Сохраняем Joomla-запись, чтобы использовать в validateCredentials
        $this->pendingJoomlaUser = $joomlaUser;

        // Возвращаем заглушку — незаписанный User с email/username
        $placeholder = new User();
        $placeholder->forceFill([
            'email'    => $joomlaUser->email,
            'username' => $joomlaUser->username ?? $joomlaUser->name,
        ]);

        return $placeholder;
    }

    /**
     * Проверяем пароль. Если пользователь из Joomla — проверяем MD5/bcrypt,
     * при успехе создаём запись в users, удаляем из pc0ec_users.
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if ($this->pendingJoomlaUser === null) {
            return parent::validateCredentials($user, $credentials);
        }

        $joomla        = $this->pendingJoomlaUser;
        $plainPassword = $credentials['password'];
        $hash          = $joomla->password;

        // Определяем тип хэша и проверяем пароль
        if (str_starts_with($hash, '$2y$')) {
            $valid = Hash::check($plainPassword, $hash);
        } else {
            // Чистый MD5 (без соли)
            $valid = hash_equals(md5($plainPassword), $hash);
        }

        $this->pendingJoomlaUser = null;

        if (!$valid) {
            return false;
        }

        // Пароль верный — мигрируем пользователя в таблицу users
        $newUser = User::create([
            'email'      => $joomla->email,
            'username'   => $joomla->username ?? $joomla->name,
            'password'   => $plainPassword, // cast 'hashed' сам сделает bcrypt
            'published'  => $joomla->block ? 0 : 1,
            'created_at' => $joomla->registerDate ?: now(),
            'joomla_id'  => $joomla->id,
        ]);

        // Удаляем запись из старой таблицы Joomla
        DB::table('pc0ec_users')->where('id', $joomla->id)->delete();

        // Подменяем атрибуты заглушки реальными данными нового пользователя,
        // чтобы auth()->login() записал правильный ID в сессию
        $user->setRawAttributes($newUser->getAttributes());
        $user->exists = true;

        return true;
    }
}
