<?php

namespace Domain\SiteNew\ViewModels;


use App\Models\SiteNew;
use App\Models\SiteNewItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class SiteNewViewModel
{
    use Makeable;

    public function categories(): LengthAwarePaginator|null
    {
        return SiteNew::query()
            ->where('published', 1)
            ->with('item')
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));

    }

    public function getCategories(): Collection|null
    {
        return Cache::rememberForever('site_new_categories', function () {

            return SiteNew::query()
                ->where('published', 1)
                ->with('item')
                ->orderBy('created_at', 'desc')
                ->get();
        });

    }

    public function category($slug): Model|null
    {
        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'site-new-category-slug-' . md5($slug);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($slug) {

            return SiteNew::query()
                ->where('published', 1)
                ->where('slug', $slug)
                ->with('item')
                ->first();
        });

    }

    public function item($slug): Model|null
    {

        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'site-new-slug-' . md5($slug);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($slug) {

            return SiteNewItem::query()
                ->where('published', 1)
                ->where('slug', $slug)
                ->with('category')
                ->first();
        });

    }

    public function category_items($category_id): Collection|null
    {

        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'site-new-category-items-slug-' . md5($category_id);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($category_id) {
            return SiteNewItem::query()
                ->where('published', 1)
                ->where('site_new_id', $category_id)
                ->with('category')
                ->get();
        });

    }

    public function category_items_paginate($category_id): LengthAwarePaginator|null
    {
        return SiteNewItem::query()
            ->where('published', 1)
            ->where('site_new_id', $category_id)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));


    }

    public function items(): Collection|null
    {
        return Cache::rememberForever('site_new_items', function () {

            return SiteNewItem::query()
                ->where('published', 1)
                ->with('category')
                ->orderBy('created_at', 'desc')
                ->get();
        });

    }


}
