<?php

namespace App\View\Components\Home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConsultationComponent extends Component
{
public array $item;
    public function __construct()
    {
        $setting = config2_array('moonshine.setting');
        $item['title'] = ($setting['consult_title'])??'';
        $item['step1'] = ($setting['consult_step1'])??'';
        $item['step2'] = ($setting['consult_step2'])??'';
        $item['step3'] = ($setting['consult_step3'])??'';
        $item['button1'] = ($setting['consult_button1'])??'';
        $item['button2'] = ($setting['consult_button2'])??'';
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.consultation-component');
    }
}
