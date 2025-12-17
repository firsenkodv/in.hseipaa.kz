<?php

namespace App\View\Components\Enter;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderEnterComponent extends Component
{
public object | null $user;
    public function __construct()
    {
        if(auth()->check()) {
            $this->user = auth()->user();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.enter.header-enter-component');
    }
}
