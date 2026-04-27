<?php

namespace App\Http\Controllers\FancyBox;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\ROP;
use App\Models\User;
use Domain\CabinetMessage\ViewModels\CabinetMessageViewModel;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
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


        if($request->template == 'manager_set_tarif') {
            $data   = json_decode($request->data);
            $userId = (int) $data->user_id;
            $user   = User::findOrFail($userId);
            $tarifs = Tarif::make()->tarifs();
            return view('fancybox.forms.manager_set_tarif', [
                'user'   => $user,
                'tarifs' => $tarifs,
            ]);
        }

        if($request->template == 'to_user_message') {

            $data   = json_decode($request->data);
            $userId = (int) $data->user_id;
            $action = $data->action ?? 'message';

            // Роль берём из сессии — её устанавливает middleware при каждом запросе к кабинету
            $role = session('active_role', '');

            $staff = $this->resolveStaff();

            if ($staff) {
                CabinetMessageViewModel::make()->markReadByStaff($userId);
            }

            $messages = $staff
                ? CabinetMessageViewModel::make()->allMessagesForUser($userId)
                : collect();

            return view('fancybox.forms.cabinet.to_user_message', [
                'user_id'  => $userId,
                'action'   => $action,
                'messages' => $messages,
                'staff'    => $staff,
                'role'     => $role,
            ]);
        }


        return view('fancybox.forms.error.error_form');

    }

    private function resolveStaff(): mixed
    {
        if ($email = session()->get('m')) {
            $staff = ManagerViewModel::make()->m($email);
            if ($staff) return $staff;
        }

        if ($email = session()->get('r')) {
            $staff = ROPViewModel::make()->r($email);
            if ($staff) return $staff;
        }

        return null;
    }

}
