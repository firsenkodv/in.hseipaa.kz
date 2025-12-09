<?php

namespace App\View\Components\Mzp;

use Closure;
use Domain\Mzp\ViewModels\MzpViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MzpMenuComponent extends Component
{
    public $left_menu;
    public function __construct()
    {
        $this->left_menu = MzpViewModel::make()->items();
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mzp.mzp-menu-component');
    }
}
