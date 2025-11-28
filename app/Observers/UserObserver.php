<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     * Обработайте событие, "созданное" пользователем.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     * Обработайте событие "обновление" пользователя.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     * Обработайте событие "удален" пользователем.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     * Обработайте событие "восстановлено" пользователем.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     * Обработайте пользовательское событие "принудительное удаление".
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
