<?php

namespace App\Http\Controllers\UseFul;

use App\Http\Controllers\Controller;
use App\Models\Useful;
use Domain\UseFul\ViewModels\UseFulViewModel;
use Illuminate\Contracts\View\View;

class UseFulController extends Controller
{
    public function section(Useful $useful):View {
        // Возвращаем список категорий с пагинацией
        $categories = $useful->category()->paginate(config('site.constants.paginate'));
        if(!$categories) {
            abort(404);
        }
        return view('pages.useful.section.section', [
            'section' => $useful,
            'categories' => $categories,
        ]);
    }

    public function category(Useful $useful, $category_slug):View {

        $category = UseFulViewModel::make()->category($category_slug);

        if(!$category) {
            abort(404);
        }
        $subcategories = $category->subcategory()->paginate(config('site.constants.paginate'));



        if(!$subcategories) {
            abort(404);
        }

        return view('pages.useful.category.category', [
            'section' => $useful,
            'category' => $category,
            'subcategories' => $subcategories
        ]);
    }

    public function subcategory(Useful $useful, $category_slug, $subcategory_slug):View {

        $category = UseFulViewModel::make()->category($category_slug);
        if(!$category) {
            abort(404);
        }
        $subcategory = UseFulViewModel::make()->subcategory($subcategory_slug);
        if(!$subcategory) {
            abort(404);
        }
        $items = $subcategory->item()->paginate(config('site.constants.paginate'));
        if(!$items) {
            abort(404);
        }

        return view('pages.useful.category.subcategory', [
            'section' => $useful,
            'category' => $category,
            'subcategory' => $subcategory,
            'items' => $items
        ]);
    }

    public function item(Useful $useful, $category_slug, $subcategory_slug, $item_slug):View {
        $category = UseFulViewModel::make()->category($category_slug);
        if(!$category) {
            abort(404);
        }
        $subcategory = UseFulViewModel::make()->subcategory($subcategory_slug);
        if(!$subcategory) {
            abort(404);
        }
        $item = UseFulViewModel::make()->item($item_slug);
        if(!$item) {
            abort(404);
        }
        return view('pages.useful.item.item', [
            'section' => $useful,
            'category' => $category,
            'subcategory' => $subcategory,
            'item' => $item,
        ]);
    }
}
