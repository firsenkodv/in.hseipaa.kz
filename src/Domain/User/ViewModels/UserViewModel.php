<?php

namespace Domain\User\ViewModels;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class UserViewModel
{
    use Makeable;

    public function UserCreate($request):Model | null
    {
        return User::Create($request);

    }

    public function User():Model | null
    {
        if(auth()->check()) {
            return auth()->user()->load(['UserHuman']);
        }
        return null;
    }
}
