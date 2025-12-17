<?php

namespace Domain\Mzp\ViewModels;

use App\Models\Mzp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class MzpViewModel
{

    use Makeable;


    public function items(): Collection|null
    {
        return Cache::rememberForever('mzp_items', function () {

            return Mzp::class::query()
                ->where('published', 1)
                ->orderBy('y', 'desc')
                ->get();


        });
    }

    public function item($slug): Model|null
    {
        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'mzp-item-slug-' . md5($slug);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($slug) {
            return Mzp::class::query()
                ->where('published', 1)
                ->where('slug', $slug)
                ->first();
        });

    }



}


