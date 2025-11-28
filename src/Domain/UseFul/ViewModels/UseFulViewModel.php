<?php

namespace Domain\UseFul\ViewModels;

use App\Models\Useful;
use App\Models\UsefulCategory;
use App\Models\UsefulItem;
use App\Models\UsefulSubcategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class UseFulViewModel
{
    use Makeable;

    public function sections(): Collection | null
    {

        return Cache::rememberForever('useful_sections', function () {

            return Useful::query()
                ->where('published', 1)
                ->with([
                    'category' => function ($query) {
                        $query->where('published', 1);
                    }])
                ->orderBy('created_at', 'desc')
                ->get();
        });

    }

    public function categories(): Collection | null
    {

        return Cache::rememberForever('useful_categories', function () {

            return UsefulCategory::query()
                ->where('published', 1)
                ->with([
                    'useful' => function ($query) {
                        $query->where('published', 1);
                    }])
                ->with([
                    'subcategory' => function ($query) {
                        $query->where('published', 1);
                    }])
               ->orderBy('created_at', 'desc')
                ->get();
        });

    }

    public function subcategories(): Collection | null
    {

        return Cache::rememberForever('useful_subcategories', function () {

            return UsefulSubcategory::query()
                ->where('published', 1)
                ->with([
                    'category' => function ($query) {
                        $query->where('published', 1);
                    }])
                ->with([
                    'item' => function ($query) {
                        $query->where('published', 1);
                    }])
                ->orderBy('created_at', 'desc')
                ->get();
        });

    }

    public function category($slug): Model | null
    {
       return UsefulCategory::query()
            ->where('published', 1)
            ->where('slug', $slug)
           ->with([
               'subcategory' => function ($query) {
                   $query->where('published', 1);
               }])
           ->with([
               'useful' => function ($query) {
                   $query->where('published', 1);
               }])
            ->first();

    }

    public function subcategory($slug): Model | null
    {
       return UsefulSubcategory::query()
            ->where('published', 1)
            ->where('slug', $slug)
           ->with([
               'category' => function ($query) {
                   $query->where('published', 1);
               }])
           ->with([
               'item' => function ($query) {
                   $query->where('published', 1);
               }])
            ->first();

    }

    public function item($slug): Model | null
    {
       return UsefulItem::query()
            ->where('published', 1)
            ->where('slug', $slug)
           ->with([
               'subcategory' => function ($query) {
                   $query->where('published', 1);
               }])
            ->first();

    }


    public function categoryId($id): Model | null
    {
        return UsefulCategory::query()
            ->where('published', 1)
            ->where('id', $id)
            ->with([
                'subcategory' => function ($query) {
                    $query->where('published', 1);
                }])
            ->with([
                'useful' => function ($query) {
                    $query->where('published', 1);
                }])
            ->first();

    }




}
