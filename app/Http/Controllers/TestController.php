<?php

namespace App\Http\Controllers;


class TestController extends Controller
{
    public function test()
    {
        //flash()->info('Hello');

        if(auth()->check()) {
            $user = auth()->user();
        } else {
            $user = false;
        }

       return view('test', [
           'user' => $user
           ]
       );
    }


}
