<?php

namespace Domain\Contact\ViewModels;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class ContactViewModel
{
    use Makeable;

    public function listContacts(): array|null
    {

        $list_contacts = Cache::rememberForever('list_contacts', function () {

            return config2_array('moonshine.contact');

        });

        return $list_contacts;

    }

    public function activeCityCoordinates(): string|null
    {

        $session_city = (session()->get('city_title')) ?? '';

        if ($session_city) {
            $a = (config2_array('moonshine.contact')) ?? [];

            if(count($a['json_cities'])) {
                foreach ($a['json_cities'] as $contact) {
                    if ($contact['json_title'] === $session_city) {
                        return trim($contact['json_coordinates']);
                    }
                }
            }
        }

        return null;

    }


}
