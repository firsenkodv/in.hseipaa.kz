<?php

namespace Domain\UserSex\ViewModels;

use App\Models\UserSex;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class UserSexViewModel
{
    use Makeable;

    public function Sexes(): Collection|null
    {
        return UserSex::query()
            ->orderBy('sorting', 'DESC')
            ->get();

    }
}
