<?php

namespace App\Http\Controllers\Mzp;

use App\Http\Controllers\Controller;
use Domain\Mzp\ViewModels\MzpViewModel;
use Illuminate\Contracts\View\View;

class MzpController extends Controller
{
    public function items():View {

        $items = MzpViewModel::make()->items();

        if(!$items) {
            abort(404);
        }

        return view('pages.mzp.items', [
            'items' => $items,
        ]);
    }

    public function item($item_slug):View {

        $item = MzpViewModel::make()->item($item_slug);

        if(!$item) {
            abort(404);
        }

        return view('pages.mzp.item', [
            'item' => $item,
        ]);
    }
}
