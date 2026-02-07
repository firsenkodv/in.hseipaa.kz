<?php

namespace App\View\Components\CabinetManager;

use Closure;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoginManager extends Component
{
    public  ?object $m = null;
    public function __construct()
    {
        if (session()->exists('m')) {
            $m = ManagerViewModel::make()->m(session()->get('m'));

            if (!is_null($m)) {
                $this->m =  $m;
            }

        }
    }
    public function render(): View|Closure|string
    {
        return view('components.cabinet-manager.login-manager');
    }
}
