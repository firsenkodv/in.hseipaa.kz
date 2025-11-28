<?php

namespace App\View\Components\Content;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentFaqComponent extends Component
{
    public string $faq_title;
    public  $faq;
    public function __construct($content)
    {
        $this->faq_title = (isset($content->faq_title))? $content->faq_title : '';
        $this->faq = (isset($content->faq))? $content->faq : null;



    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.content-faq-component');
    }
}
