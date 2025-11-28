<?php

namespace App\Http\Controllers\SiteNew;

use App\Http\Controllers\Controller;
use Domain\Company\ViewModel\CompanyViewModel;
use Domain\SiteNew\ViewModels\SiteNewViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SiteNewController extends Controller
{
    public function categories(): View
    {
        $categories = SiteNewViewModel::make()->categories();

        if(!$categories) {
            abort(404);
        }
        $moonshine_page = [];
        if(config2_array('moonshine.new')) {
            $moonshine_page = config2_array('moonshine.new');
        }
        return view('pages.new.category.categories', [
            'categories' => $categories,
            'faq' =>  json_decode(json_encode($moonshine_page))

        ]);
    }

    public function category($category_slug): View
    {
        $category = SiteNewViewModel::make()->category($category_slug);
        if(!$category) {
            abort(404);
        }
        $items = $category->item()->paginate(config('site.constants.paginate'));

        if(!$items) {
            abort(404);
        }

        return view('pages.new.category.category', [
            'category' => $category,
            'items' => $items,

        ]);
    }

    public function item($category_slug, $item_slug): View
    {
        $category = SiteNewViewModel::make()->category($category_slug);

        if(!$category) {
            abort(404);
        }

        $item = SiteNewViewModel::make()->item($item_slug);

        if(!$item) {
            abort(404);
        }

        return view('pages.new.item.item', [
            'category' => $category,
            'item' => $item,
        ]);
    }
}
