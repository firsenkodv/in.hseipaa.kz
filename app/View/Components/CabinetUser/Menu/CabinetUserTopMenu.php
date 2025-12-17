<?php

namespace App\View\Components\CabinetUser\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetUserTopMenu extends Component
{
    public object | null $user;
    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.cabinet-user-top-menu');
    }
}
