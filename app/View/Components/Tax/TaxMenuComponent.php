<?php

namespace App\View\Components\Tax;

use Closure;
use Domain\Tax\ViewModels\TaxViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaxMenuComponent extends Component
{
public $left_menu;
    public function __construct()
    {
        $this->left_menu = TaxViewModel::make()->items();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tax.tax-menu-component');
    }
}
