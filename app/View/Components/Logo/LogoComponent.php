<?php

namespace App\View\Components\Logo;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LogoComponent extends Component
{

    public string|null $routeName;

    public function __construct ( $routeName)
    {

        $this->routeName = ($routeName == 'home') ? $routeName : null;


    }

    /**
     * Get the view / contents that represent the component.
     */

    public function render(): View|Closure|string
    {
        return view('components.logo.logo-component');
    }

}
