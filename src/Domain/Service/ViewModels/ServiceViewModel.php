<?php

namespace Domain\Service\ViewModels;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;
use App\Models\Useful;
use App\Models\UsefulCategory;
use App\Models\UsefulItem;
use App\Models\UsefulSubcategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class ServiceViewModel
{
    use Makeable;

    public function sections(): Collection | null
    {

        return Cache::rememberForever('service_sections', function () {

            return Service::query()
                ->where('published', 1)
                ->with('category')
                ->with('category')
                ->orderBy('created_at', 'desc')
                ->get();
        });

    }

    public function categories(): Collection | null
    {

        return Cache::rememberForever('service_categories', function () {
            return ServiceCategory::query()
                ->where('published', 1)
                ->with('service')
                ->with('item')
                ->orderBy('created_at', 'desc')
                ->get();
        });

    }



    public function category($slug): Model | null
    {

        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'service-category-slug-' . md5($slug);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($slug) {
        return ServiceCategory::query()
            ->where('published', 1)
            ->where('slug', $slug)
            ->with('service')
            ->with('item')
            ->first();
        });

    }
    public function categoryId($id): Model | null
    {

        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'service-category-id-' . md5($id);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($id) {
        return ServiceCategory::query()
            ->where('published', 1)
            ->where('id', $id)
            ->with('service')
            ->with('item')
            ->first();
        });

    }


    public function item($slug): Model | null
    {
        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'service-item-slug-' . md5($slug);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($slug) {

        return ServiceItem::query()
            ->where('published', 1)
            ->where('slug', $slug)
            ->with('category')
            ->first();
        });

    }
}
