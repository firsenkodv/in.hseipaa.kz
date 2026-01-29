<?php

namespace App\View\Components\CheckingCounterparty;

use Closure;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckingCounterpartyComponent extends Component
{

    public int $check;
    public bool $tarif_id;
    public function __construct(int $counterparty)
    {

        $user = UserViewModel::make()->User();
        if (!is_null($user)) {
            $this->tarif_id = (is_null($user->tarif_id))? 0 : $user->tarif_id;
        } else {
            $this->tarif_id = 0;
        }
        $this->check = $counterparty;

    }


    public function render(): View|Closure|string
    {
        return view('components.checking-counterparty.checking-counterparty-component');
    }
}
