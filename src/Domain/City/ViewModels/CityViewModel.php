<?php

namespace Domain\City\ViewModels;

use App\Models\UserCity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CityViewModel
{
    use Makeable;

    public function Cities(): Collection|null
    {
        return Cache::rememberForever('cities', function () {
            return UserCity::query()
                ->orderBy('sorting', 'DESC')
                ->get();
        });

    }
}
