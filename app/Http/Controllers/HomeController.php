<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        //flash()->info('Hello');
        if(auth()->check()) {
            $user = auth()->user();
        } else {
            $user = false;
        }
        $moonshine_page = [];
        if(config2_array('moonshine.home')) {
            $moonshine_page = config2_array('moonshine.home');
        }


       return view('home', [
           'user' => $user,
           'faq' =>  json_decode(json_encode($moonshine_page))


           ]
       );
    }


}
