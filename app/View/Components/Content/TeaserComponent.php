<?php

namespace App\View\Components\Content;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TeaserComponent extends Component
{

    public $content;
    public $url;
    public function __construct($content, $url = '#')
    {
        $this->content = $content;
        $this->url = $url;

    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.teaser-component');
    }
}
