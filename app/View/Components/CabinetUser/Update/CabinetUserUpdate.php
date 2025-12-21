<?php

namespace App\View\Components\CabinetUser\Update;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetUserUpdate extends Component
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
        return view('components.cabinet-user.update.cabinet-user-update');
    }
}
