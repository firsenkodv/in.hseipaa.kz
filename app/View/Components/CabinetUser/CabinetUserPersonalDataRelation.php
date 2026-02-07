<?php

namespace App\View\Components\CabinetUser;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CabinetUserPersonalDataRelation extends Component
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
        return view('components.cabinet-user.cabinet-user-personal-data-relation');
    }
}
