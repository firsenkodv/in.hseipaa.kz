<?php

namespace App\View\Components\Form;

use App\Enums\User\Status;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormRadio2Component extends Component
{
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.form-radio2-component');
    }
}
