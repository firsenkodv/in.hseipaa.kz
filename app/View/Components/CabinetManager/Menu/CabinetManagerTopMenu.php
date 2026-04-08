<?php

namespace App\View\Components\CabinetManager\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetManagerTopMenu extends Component
{
    public ?object $user;
    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function render(): View|Closure|string
    {
        return view('components.cabinet-manager.menu.cabinet-manager-top-menu');
    }
}
