<?php

namespace App\View\Components\CabinetRop;

use Closure;
use Domain\ROP\ViewModels\ROPViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoginRop extends Component
{

    public  ?object $r = null;
    public function __construct()
    {
        if (session()->exists('r')) {
            $r = ROPViewModel::make()->r(session()->get('r'));

            if (!is_null($r)) {
                $this->r =  $r;
            }

        }
    }

    public function render(): View|Closure|string
    {
        return view('components.cabinet-rop.login-rop');
    }
}
