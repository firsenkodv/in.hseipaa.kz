<?php

namespace App\View\Components\Content;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentTarifComponent extends Component
{
    public object $content;
    public function __construct($content = null)
    {
        $this->content = $content;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.content-tarif-component');
    }
}
