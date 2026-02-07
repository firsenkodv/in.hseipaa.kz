<?php

namespace App\View\Components\CabinetRop\Update;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetRopUpdate extends Component
{
    public ?object $user = null;
    public function __construct($user)
    {
        $this->user = $user;

    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cabinet-rop.update.cabinet-rop-update');
    }
}
