<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AxiosController extends Controller
{
    public function async(Request $request) {

        //dd($request->all());

        if($request->template == 'call_me_blue') {
            return view('axios.forms.call_me_blue');
        }


        return view('axios.forms.error.error_form');

    }


}
