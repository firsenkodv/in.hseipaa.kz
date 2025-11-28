<?php

namespace App\Http\Controllers;

use Domain\Contact\ViewModels\ContactViewModel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contacts()
    {
        $contacts = ContactViewModel::make()->listContacts();
        $coordinates = ContactViewModel::make()->activeCityCoordinates();
        $moonshine_page = [];
        if(config2_array('moonshine.contact')) {
            $moonshine_page = config2_array('moonshine.contact');
        }


        return view('pages.contacts',
            [
                'contacts' => $contacts,
                'coordinates' => ($coordinates)??'',
                'faq' =>  json_decode(json_encode($moonshine_page))
            ]);
    }
}
