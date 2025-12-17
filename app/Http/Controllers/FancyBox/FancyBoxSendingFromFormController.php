<?php

namespace App\Http\Controllers\FancyBox;

use App\Events\Form\FancyBoxSendingFromFormEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCallMeBlueRequest;
use App\Http\Requests\RequestCallMeRequest;
use App\Http\Requests\RequestConsultMeRequest;
use App\Http\Requests\RequestForTrainingRequest;
use App\Http\Requests\SendSubscriptionMeRequest;
use Domain\SavedFormData\ViewModel\SavedFormDataViewModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


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
