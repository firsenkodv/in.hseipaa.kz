<?php

namespace App\View\Components\CabinetRop;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetRopPersonalData extends Component
{
    public ?object $user;

    public function __construct($user)
    {
              $this->user = $user;
    }


    public function render(): View|Closure|string
    {
        return view('components.cabinet-rop.cabinet-rop-personal-data');
    }
}
