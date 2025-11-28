<?php

namespace App\Http\Controllers\Fetch;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestRequest;
use Illuminate\Http\Request;

class FetchCityController extends Controller
{
    public function setCityDefault(Request $request) {

        /** удалим сессию **/
        session()->forget('city_title');
        session()->forget('city_phone');

        /** запустим сессию **/
        session(['city_title' => $request->title, 'city_phone' => phone($request->phone) ]); // запустим сессию



        return response()->json([
            'response' => $request->all(),
            'city_title' => session()->get('city_title'),
            'city_phone' => session()->get('city_phone'),
            ], 200);

    }

}
