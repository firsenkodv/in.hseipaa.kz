<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Domain\Company\ViewModel\CompanyViewModel;
use Domain\SiteNew\ViewModels\SiteNewViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function categories(): View
    {
        $categories = CompanyViewModel::make()->categories();

        if(!$categories) {
            abort(404);
        }

        $moonshine_page = [];
        if(config2_array('moonshine.company')) {
            $moonshine_page = config2_array('moonshine.company');
        }

        return view('pages.company.category.categories', [
            'categories' => $categories,
            'faq' =>  json_decode(json_encode($moonshine_page))
        ]);
    }

    public function category($category_slug): View
    {
        $category = CompanyViewModel::make()->category($category_slug);

        if(!$category) {
            abort(404);
        }
        $items = $category->item()->paginate(config('site.constants.paginate'));
        if(!$items) {
            abort(404);
        }
        return view('pages.company.category.category', [
            'category' => $category,
            'items' => $items,

        ]);
    }

    public function item($category_slug, $item_slug): View
    {
        $category = CompanyViewModel::make()->category($category_slug);
        if(!$category) {
            abort(404);
        }
        $item = CompanyViewModel::make()->item($item_slug);
        if(!$item) {
            abort(404);
        }

        return view('pages.company.item.item', [
            'category' => $category,
            'item' => $item,
        ]);
    }
}
