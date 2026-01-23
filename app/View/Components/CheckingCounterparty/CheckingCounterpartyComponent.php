<?php

namespace App\View\Components\CheckingCounterparty;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckingCounterpartyComponent extends Component
{

    public int $check;
    public function __construct(int $counterparty)
    {

        $this->check = $counterparty;
    }


    public function render(): View|Closure|string
    {
        return view('components.checking-counterparty.checking-counterparty-component');
    }
}
