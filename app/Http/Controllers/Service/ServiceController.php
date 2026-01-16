<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Domain\Service\ViewModels\ServiceViewModel;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function section(Service $service):View {
        // Возвращаем список категорий с пагинацией
        $categories = $service->category()->paginate(config('site.constants.paginate'));
        if(!$categories) {
            abort(404);
        }
        return view('pages.service.section.section', [
            'section' => $service,
            'categories' => $categories,
        ]);
    }



    public function category(Service $service, $category_slug):View {

        $category = ServiceViewModel::make()->category($category_slug);
        if(!$category) {
            abort(404);
        }


        $items = $category->item()->paginate(config('site.constants.paginate'));
        if(!$items) {
            abort(404);
        }

    //   dd($category);

        return view('pages.service.category.category', [
            'section' => $service,
            'category' => $category,
            'items' => $items
        ]);
    }

    public function item(Service $service, $category_slug, $item_slug):View {

        $category = ServiceViewModel::make()->category($category_slug);
        if(!$category) {
            abort(404);
        }
        $item = ServiceViewModel::make()->item($item_slug);
        if(!$item) {
            abort(404);
        }



        return view('pages.service.item.item', [
            'section' => $service,
            'category' => $category,
            'item' => $item,
        ]);
    }
}
