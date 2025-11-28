<?php

namespace Domain\Company\ViewModel;

use App\Models\CompanyCategory;
use App\Models\CompanyItem;
use App\Models\SiteNew;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CompanyViewModel
{
    use Makeable;

    public function categories(): Collection | null
    {
        return Cache::rememberForever('company_categories', function () {

            return  CompanyCategory::query()
                ->where('published', 1)
                ->with('item')
                ->orderBy('created_at', 'desc')
                ->get();
        });

    }

    public function category($slug): Model | null
    {
        return  CompanyCategory::query()
            ->where('published', 1)
            ->where('slug', $slug)
            ->with('item')
            ->first();

    }

    public function item($slug): Model | null
    {
        return CompanyItem::query()
            ->where('published', 1)
            ->where('slug', $slug)
            ->with('category')
            ->first();

    }


}
