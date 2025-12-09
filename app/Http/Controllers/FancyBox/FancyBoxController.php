<?php

namespace App\Http\Controllers\FancyBox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FancyBoxController extends Controller
{
    public function fancybox(Request $request) {

        //dd($request->all());

        if($request->template == 'subscription_me') {
            return view('fancybox.forms.subscription_me');
        }

        if($request->template == 'call_me') {
            return view('fancybox.forms.call_me');
        }

        if($request->template == 'request_for_training') {
            return view('fancybox.forms.request_for_training');
        }
        if($request->template == 'consult_me') {
            return view('fancybox.forms.consult_me');
        }

        return view('fancybox.forms.error.error_form');

    }

}
