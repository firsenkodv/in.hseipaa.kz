<?php

namespace App\Http\Controllers\FancyBox;

use App\Events\Form\FancyBoxSelectTarifEvent;
use App\Events\Form\FancyBoxSendingFromFormEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\ContractSignRequest;
use App\Http\Requests\Cabinet\UserReportCreateRequest;
use App\Http\Requests\Cabinet\UserReportUpdateRequest;
use App\Http\Requests\CabinetAdmin\AdminContractCreateRequest;
use App\Http\Requests\CabinetManager\ManagerReportAcceptRequest;
use App\Http\Requests\CabinetManager\ManagerReportUpdateRequest;
use App\Http\Requests\CabinetAdmin\AdminContractUpdateRequest;
use App\Http\Requests\CabinetAdmin\AdminTrainingUpdateRequest;
use App\Http\Requests\CabinetAdmin\AdminUserCreateRequest;
use App\Http\Requests\RequestCallMeBlueRequest;
use App\Mail\Contract\ContractCreatedMail;
use App\Mail\Contract\ContractSignedMail;
use App\Models\Contract;
use App\Models\Report;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Requests\RequestCallMeRequest;
use App\Http\Requests\RequestConsultMeRequest;
use App\Http\Requests\RequestForTrainingRequest;
use App\Http\Requests\SendSubscriptionMeRequest;
use App\Mail\Auth\AdminNewUserNotificationMail;
use App\Mail\Auth\UserRegisteredMail;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\SavedFormData\ViewModel\SavedFormDataViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;


class FancyBoxSendingFromFormController extends Controller
{
    /** подписаться  */
    public function fancyboxSubscriptionMe(SendSubscriptionMeRequest $request) {

      SavedFormDataViewModel::make()->save($request);
        $data = $request->except('url');
        FancyBoxSendingFromFormEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }

    /** заявка на обучение  */
    public function fancyboxRequestForTraining(RequestForTrainingRequest $request) {

      SavedFormDataViewModel::make()->save($request);
      $data = $request->except('url');
      FancyBoxSendingFromFormEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }

    /** перезвоните мне  */
    public function fancyboxCallMe(RequestCallMeRequest $request) {

      SavedFormDataViewModel::make()->save($request);
        $data = $request->except('url');
        FancyBoxSendingFromFormEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }

    /** консультация  */
    public function fancyboxConsultMe(RequestConsultMeRequest $request) {

      SavedFormDataViewModel::make()->save($request);
        $data = $request->except('url');
        FancyBoxSendingFromFormEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }

    /** Выбрали тариф  */
    public function fancyboxSelectTarif(Request $request) {
        if($request->user_id) {
            $user = UserViewModel::make()->User();
            // Добавляем данные пользователя в запрос
            $request->merge([
                'username' => $user->username,
                'phone' => ($user->phone)? format_phone($user->phone) : ' - ',
                'email' => $user->email
            ]);
        }

        $data = $request->except('url', 'user_id');
        FancyBoxSelectTarifEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }

    /** подписание договора пользователем */
    public function fancyboxContractSign(ContractSignRequest $request): \Illuminate\Http\JsonResponse
    {
        $contract = Contract::with('user.Manager')->findOrFail($request->integer('contract_id'));
        $contract->update(['is_signed' => true]);

        if ($contract->email) {
            Mail::to($contract->email)->queue(new ContractSignedMail($contract, $request->ip()));
        }

        return response()->json([
            'response' => [
                'contract_id' => $contract->id,
                'signed'      => true,
            ],
        ], 200);
    }

    /** создание договора администратором */
    public function fancyboxAdminContractCreate(AdminContractCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = Str::random(64);

        $lastSeq = Contract::whereYear('created_at', now()->year)
            ->whereNotNull('contract_number')
            ->get()
            ->map(fn($c) => (int) explode('/', $c->contract_number)[0])
            ->max() ?? 0;

        $contractNumber = sprintf('%02d/%s/%s', $lastSeq + 1, now()->format('m'), now()->format('y'));

        Contract::create([
            'user_id'         => $request->integer('user_id'),
            'contract_number' => $contractNumber,
            'full_name'       => $request->input('fio'),
            'email'           => $request->input('email'),
            'phone'           => $request->input('phone'),
            'discipline'      => $request->input('training_id'),
            'date_start'      => Carbon::createFromFormat('d.m.Y', $request->input('date_from')),
            'date_end'        => Carbon::createFromFormat('d.m.Y', $request->input('date_to')),
            'price'           => $request->input('price'),
            'currency'        => $request->input('currency'),
            'hours'           => $request->integer('hours'),
            'public_token'    => $token,
            'organizations'   => \App\Enums\OrganizationEnum::fromLabel($request->input('organization'))?->value,
        ]);

        $user    = User::with('Manager')->find($request->integer('user_id'));
        $manager = $user?->Manager;

        $publicUrl = route('contract.public', $token);

        $orgEnum = \App\Enums\OrganizationEnum::fromLabel($request->input('organization'));

        $contractData = array_merge(
            $request->only(['fio', 'email', 'phone', 'training_id', 'date_from', 'date_to', 'price', 'currency', 'hours']),
            [
                'contract_number'    => $contractNumber,
                'organization_label' => $request->input('organization'),
                'organization_logo'  => $orgEnum ? asset($orgEnum->logo()) : null,
                'organization_logo_size' => $orgEnum ? $orgEnum->logoSize() : null,
                'manager_name'       => $manager?->username,
                'manager_email'      => $manager?->email,
                'manager_phone'      => $manager?->phone ? format_phone($manager->phone) : null,
                'public_url'         => $publicUrl,
            ]
        );

        Mail::to($request->input('email'))->queue(new ContractCreatedMail($contractData));

        return response()->json(['response' => [
            'public_url'        => $publicUrl,
            'user_id'           => $request->integer('user_id'),
            'contract_created'  => true,
        ]], 200);
    }

    /** создание пользователя администратором */
    public function fancyboxAdminUserCreate(AdminUserCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $plainPassword = $request->input('password');

        $user = UserViewModel::make()->UserCreate($request->all());

        $userData = [
            'username' => $user->username,
            'email'    => $user->email,
            'company'  => $user->company,
            'password' => $plainPassword,
        ];

        Mail::to($user->email)->queue(new UserRegisteredMail($userData));
        Mail::to(config('app.mail_admin'))->queue(new AdminNewUserNotificationMail($userData));

        return response()->json(['response' => $request->all()], 200);
    }

    /** обновление договора администратором */
    public function fancyboxAdminContractUpdate(AdminContractUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $contract = Contract::findOrFail($request->integer('contract_id'));

        $contract->update([
            'full_name'  => $request->input('fio'),
            'email'      => $request->input('email'),
            'phone'      => $request->input('phone'),
            'discipline' => $request->input('training_id'),
            'date_start' => Carbon::createFromFormat('d.m.Y', $request->input('date_from')),
            'date_end'   => Carbon::createFromFormat('d.m.Y', $request->input('date_to')),
            'price'      => $request->input('price'),
            'currency'   => $request->input('currency'),
            'hours'      => $request->integer('hours'),
        ]);

        $currencies = config('currency.currency');

        return response()->json([
            'response' => [
                'contract_id' => $contract->id,
                'discipline'  => $contract->discipline,
                'date_start'  => $contract->date_start->format('d.m.Y'),
                'date_end'    => $contract->date_end->format('d.m.Y'),
                'price'       => number_format((float) $contract->price, 0, '.', ' '),
                'currency'    => $currencies[$contract->currency] ?? $contract->currency,
                'hours'       => $contract->hours,
            ],
        ], 200);
    }

    /** обновление дисциплины администратором */
    public function fancyboxAdminTrainingUpdate(AdminTrainingUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $training = Training::findOrFail($request->integer('training_id'));
        $training->update(['title' => $request->input('title')]);

        return response()->json(['response' => $request->all()], 200);
    }

    /** создание отчёта пользователем */
    public function fancyboxUserReportCreate(UserReportCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        $certData = null;
        if ($request->input('certificates')) {
            $decoded = json_decode($request->input('certificates'), true);
            $certData = is_array($decoded) && count($decoded) ? $decoded : null;
        }

        Report::create([
            'user_id'         => $user->id,
            'period_from'     => Carbon::createFromFormat('d.m.Y', $request->input('report_period_from')),
            'period_to'       => Carbon::createFromFormat('d.m.Y', $request->input('report_period_to')),
            'report_type'     => trim($request->input('report_type')),
            'discipline_name' => trim($request->input('discipline_name')),
            'school_name'     => trim($request->input('school_name')),
            'certificates'    => $certData,
        ]);

        return response()->json(['response' => ['report_created' => true]], 200);
    }

    /** редактирование отчёта пользователем */
    public function fancyboxUserReportUpdate(UserReportUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user   = auth()->user();
        $report = Report::where('id', $request->integer('report_id'))
            ->where('user_id', $user->id)
            ->firstOrFail();

        $certData = $report->certificates ? $report->certificates->toArray() : null;
        if ($request->input('certificates') !== null && $request->input('certificates') !== '') {
            $decoded  = json_decode($request->input('certificates'), true);
            $certData = is_array($decoded) && count($decoded) ? $decoded : null;
        }

        $report->update([
            'period_from'     => Carbon::createFromFormat('d.m.Y', $request->input('report_period_from')),
            'period_to'       => Carbon::createFromFormat('d.m.Y', $request->input('report_period_to')),
            'report_type'     => trim($request->input('report_type')),
            'discipline_name' => trim($request->input('discipline_name')),
            'school_name'     => trim($request->input('school_name')),
            'certificates'    => $certData,
        ]);

        return response()->json(['response' => [
            'report_updated' => true,
            'report_id'      => $report->id,
        ]], 200);
    }

    /** обновление отчёта менеджером */
    public function fancyboxManagerReportUpdate(ManagerReportUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $m = ManagerViewModel::make()->m(session('m'));
        $report = Report::with('user')
            ->where('id', $request->integer('report_id'))
            ->where('accepted', false)
            ->whereHas('user', fn($q) => $q->where('manager_id', $m->id))
            ->firstOrFail();

        $report->update([
            'period_from'     => Carbon::createFromFormat('d.m.Y', $request->input('report_period_from')),
            'period_to'       => Carbon::createFromFormat('d.m.Y', $request->input('report_period_to')),
            'report_type'     => trim($request->input('report_type')),
            'discipline_name' => trim($request->input('discipline_name')),
            'school_name'     => trim($request->input('school_name')),
        ]);

        return response()->json(['response' => [
            'manager_report_updated' => true,
            'report_id'              => $report->id,
        ]], 200);
    }

    /** принятие отчёта менеджером */
    public function fancyboxManagerReportAccept(ManagerReportAcceptRequest $request): \Illuminate\Http\JsonResponse
    {
        $m = ManagerViewModel::make()->m(session('m'));
        $report = Report::with('user')
            ->where('id', $request->integer('report_id'))
            ->where('accepted', false)
            ->whereHas('user', fn($q) => $q->where('manager_id', $m->id))
            ->firstOrFail();

        $report->update(['accepted' => true]);

        return response()->json(['response' => [
            'manager_report_accepted' => true,
            'report_id'               => $report->id,
        ]], 200);
    }

    /** перезвоните мне с голубой, горизонтальной, сквозной формы  */
    public function fancyboxCallMeBlue(RequestCallMeBlueRequest $request) {

      SavedFormDataViewModel::make()->save($request);
        $data = $request->except('url');
        FancyBoxSendingFromFormEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }


}
