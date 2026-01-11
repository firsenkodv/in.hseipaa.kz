<?php

namespace App\Http\Controllers\FancyBox;

use App\Http\Controllers\Controller;
use App\Models\User;
use Domain\Tarif\ViewModels\Tarif;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\Request;

class FancyBoxController extends Controller
{
    public function fancybox(Request $request) {



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

        if($request->template == 'cabinet_user_social_description') {
            return view('fancybox.forms.cabinet_user_social_description');
        }

        if($request->template == 'select_tarif') {

            $tarif = Tarif::make()->tarif(json_decode($request->data)->tarif_id);
            $user = UserViewModel::make()->User();
            return view('fancybox.forms.select_tarif', [
                'tarif' => $tarif,
                'user' => $user,
            ]);
        }

        return view('fancybox.forms.error.error_form');

    }

}
