<?php

namespace Domain\Search\ViewModel;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;
use App\Models\SiteNew;
use App\Models\SiteNewItem;
use App\Models\UsefulCategory;
use App\Models\UsefulItem;
use App\Models\UsefulSubcategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class SearchViewModel
{
    use Makeable;

    public function search(string $search): LengthAwarePaginator
    {
        $like = '%' . $search . '%';
        $match = fn($q) => $q->where('title', 'LIKE', $like)->orWhere('subtitle', 'LIKE', $like);

        $results = collect()
            ->merge(UsefulCategory::query()->with('useful')->where('published', 1)->where($match)->get())
            ->merge(UsefulSubcategory::query()->with('category.useful')->where('published', 1)->where($match)->get())
            ->merge(UsefulItem::query()->with('subcategory.category.useful')->where('published', 1)->where($match)->get())
            ->merge(SiteNew::query()->where('published', 1)->where($match)->get())
            ->merge(SiteNewItem::query()->with('category')->where('published', 1)->where($match)->get())
            ->merge(Service::query()->where('published', 1)->where($match)->get())
            ->merge(ServiceCategory::query()->with('service')->where('published', 1)->where($match)->get())
            ->merge(ServiceItem::query()->with('category.service')->where('published', 1)->where($match)->get());

        $page    = request()->get('page', 1);
        $perPage = config('site.constants.paginate', 15);

        return new LengthAwarePaginator(
            $results->forPage($page, $perPage)->values(),
            $results->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
