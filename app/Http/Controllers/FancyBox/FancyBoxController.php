<?php

namespace App\Http\Controllers\FancyBox;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Training;
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

        if($request->template == 'admin_user_create') {
            return view('fancybox.forms.cabinet.admin_user_create');
        }

        if($request->template == 'admin_training_edit') {
            $data     = json_decode($request->data);
            $training = Training::findOrFail((int) $data->training_id);
            return view('fancybox.forms.cabinet.admin_training_edit', ['training' => $training]);
        }

        if($request->template == 'admin_contract_create') {
            $data      = json_decode($request->data);
            $userId    = (int) $data->user_id;
            $user      = User::findOrFail($userId);
            $trainings = Training::select('id', 'title')
                ->orderBy('sorting', 'desc')
                ->get()
                ->map(fn($t) => ['id' => $t->id, 'title' => $t->title])
                ->toArray();
            $currencies      = config('currency.currency');
            $defaultCurrency = 'KZT';
            $organizations   = collect(\App\Enums\OrganizationEnum::cases())
                ->map(fn($case) => ['id' => $case->value, 'title' => $case->label()])
                ->values()
                ->toArray();
            return view('fancybox.forms.cabinet.admin_contract_create', [
                'user'            => $user,
                'trainings'       => $trainings,
                'currencies'      => $currencies,
                'defaultCurrency' => $defaultCurrency,
                'organizations'   => $organizations,
            ]);
        }

        if ($request->template == 'cabinet_contract_sign') {
            $data       = json_decode($request->data);
            $contractId = (int) $data->contract_id;

            $contract = Contract::where('id', $contractId)
                ->where('user_id', auth()->id())
                ->where('is_signed', false)
                ->firstOrFail();

            $currencies   = config('currency.currency');
            $currencySign = $currencies[$contract->currency] ?? $contract->currency;

            return view('fancybox.forms.cabinet.cabinet_contract_sign', [
                'contract'     => $contract,
                'currencySign' => $currencySign,
            ]);
        }

        if ($request->template == 'admin_contract_edit') {
            $data       = json_decode($request->data);
            $contractId = (int) $data->contract_id;
            $contract   = Contract::findOrFail($contractId);

            if ($contract->is_signed) {
                return view('fancybox.forms.error.error_form');
            }

            $trainings = Training::select('id', 'title')
                ->orderBy('sorting', 'desc')
                ->get()
                ->map(fn($t) => ['id' => $t->id, 'title' => $t->title])
                ->toArray();

            $currencies = config('currency.currency');

            $contractCurrency = $contract->currency;
            if (isset($currencies[$contractCurrency])) {
                $currencyCode    = $contractCurrency;
                $currencyDisplay = $currencies[$contractCurrency];
            } else {
                $found           = array_search($contractCurrency, $currencies);
                $currencyCode    = $found !== false ? $found : $contractCurrency;
                $currencyDisplay = $contractCurrency;
            }

            $trainingByTitle = collect($trainings)->firstWhere('title', $contract->discipline);
            $trainingId      = $trainingByTitle ? $trainingByTitle['id'] : null;

            return view('fancybox.forms.cabinet.admin_contract_edit', [
                'contract'        => $contract,
                'trainings'       => $trainings,
                'currencies'      => $currencies,
                'currencyCode'    => $currencyCode,
                'currencyDisplay' => $currencyDisplay,
                'trainingId'      => $trainingId,
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
