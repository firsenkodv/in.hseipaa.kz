<?php

namespace App\View\Components\Contacts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CityActiveComponent extends Component
{


    public string $active = '';
    public string $k = '';

    public function __construct($k, $city)
    {


        if (session()->get('city_title')) {
            if ($city == trim(session()->get('city_title'))) {
                $this->active = 'active';
            }
        } elseif ($k == 1) {
            $this->active = 'active';
        }

        $this->k = $k;

    }


    public function render(): View|Closure|string
    {
        return view('components.contacts.city-active-component');
    }
}
