<?php

namespace App\View\Components\CabinetRop\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserList extends Component
{
    public ?object $items;

    public function __construct($items = null)
    {
        $this->items = $items;

    }

    public function render(): View|Closure|string
    {
        return view('components.cabinet-rop.user.user-list');
    }
}
