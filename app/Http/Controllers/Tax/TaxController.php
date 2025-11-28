<?php

namespace App\Http\Controllers\Tax;

use App\Http\Controllers\Controller;
use Domain\Tax\ViewModels\TaxViewModel;
use Illuminate\Contracts\View\View;

class TaxController extends Controller
{
    public function taxCalendar($item_slug):View {

        $item = TaxViewModel::make()->item($item_slug);

        if(!$item) {
            abort(404);
        }

        return view('pages.tax.tax_calendar', [
            'item' => $item,
        ]);
    }
}
