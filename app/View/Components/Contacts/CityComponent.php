<?php

namespace App\View\Components\Contacts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CityComponent extends Component
{
    public array $cities = [];
    public string $first_city_title = '';
    public string $first_city_phone = '';
    /** @var string запишем сессию, если она есть  */
    public string $city_title = '';
    public string $city_phone = '';

    public function __construct()
    {
        $cities = (config2('moonshine.contact.json_cities')) ? to_object(config2('moonshine.contact.json_cities')) : [];

        if(count($cities)){
            $this->cities = $cities;
            $first_city = array_shift($cities);
            $this->first_city_title = $first_city->json_title;
            $this->first_city_phone = $first_city->json_phone;
        }

        $this->city_title = (session()->get('city_title')) ?? '';
        $this->city_phone = (session()->get('city_phone')) ?? '';

        if($this->city_title) {
            $this->first_city_title = $this->city_title;
        }

        if($this->city_phone) {
            $this->first_city_phone = $this->city_phone;
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.contacts.city-component', [
            'cities' => $this->cities,
            'first_city_title' => $this->first_city_title,
            'first_city_phone' => $this->first_city_phone,
            'city_title' => $this->city_title,
            'city_phone' => $this->city_phone,
        ]);
    }
}
