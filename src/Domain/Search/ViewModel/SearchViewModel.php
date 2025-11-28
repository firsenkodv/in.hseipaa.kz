<?php

namespace Domain\Search\ViewModel;

use App\Models\Useful;
use App\Models\UsefulCategory;
use App\Models\UsefulItem;
use App\Models\UsefulSubcategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class SearchViewModel
{
    use Makeable;

    public function search($search): LengthAwarePaginator
    {

        $useful_categories = UsefulCategory::query()->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('subtitle', 'LIKE', '%' . $search . '%');

        $useful_subcategories = UsefulSubcategory::query()->where('title', 'LIKE', '%' . $search . '%')->orWhere('subtitle', 'LIKE', '%' . $search . '%');

        $useful_items = UsefulItem::query()->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('subtitle', 'LIKE', '%' . $search . '%');

        $r = $useful_categories->union($useful_subcategories)->union($useful_items);
// Пагинация
        return $r->orderBy('id')->paginate(config('site.constants.paginate'));
    }
}
