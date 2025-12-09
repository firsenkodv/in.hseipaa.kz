<?php

namespace App\View\Components\Mzp;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MzpContentComponent extends Component
{
public $items;
public $item;
    public function __construct($items = null, $item = null)
    {
        $this->items = $items;
        $this->item = $item;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mzp.mzp-content-component');
    }
}
