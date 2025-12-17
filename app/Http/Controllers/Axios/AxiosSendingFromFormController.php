<?php

namespace App\Http\Controllers\Axios;

use App\Events\Form\FancyBoxSendingFromFormEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCallMeBlueRequest;
use Domain\SavedFormData\ViewModel\SavedFormDataViewModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class AxiosSendingFromFormController extends Controller
{


    /** перезвоните мне с голубой, горизонтальной, сквозной формы  */
    public function axiosCallMeBlue(RequestCallMeBlueRequest $request) {

       SavedFormDataViewModel::make()->save($request);
        $data = $request->except('url');
        FancyBoxSendingFromFormEvent::dispatch($data);

     return response()->json([
            'response' => $request->all(),
        ], 200);

    }

}
