<?php

namespace App\View\Components\CabinetManager;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetManagerPersonalDataRelation extends Component
{
    public ?object $user;
    public function __construct($user = null)
    {
        $this->user = $user;

    }

    public function render(): View|Closure|string
    {
        return view('components.cabinet-manager.cabinet-manager-personal-data-relation');
    }
}
