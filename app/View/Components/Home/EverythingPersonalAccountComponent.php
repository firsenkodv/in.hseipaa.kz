<?php

namespace App\View\Components\Home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EverythingPersonalAccountComponent extends Component
{
    public array $item;

    public function __construct()
    {
        $setting = config2_array('moonshine.setting');
        $item['title'] = ($setting['personal_account_title'])??'';
        $item['desc'] = ($setting['personal_account_desc'])??'';
        $item['button1'] = ($setting['personal_account_button1'])??'';
        $item['button2'] = ($setting['personal_account_button2'])??'';
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.everything-personal-account-component');
    }
}
