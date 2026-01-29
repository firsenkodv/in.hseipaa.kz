<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Services\CheckCounterParty;
use Illuminate\Http\Request;

class AxiosCounterPartyController extends Controller
{

    public function checkCounterParty(Request $request)
    {
        //211140006711
        $result = CheckCounterParty::make()->checkBin(trim($request->search));

       return response()->json([
            'response' => $request->all(),
            'check' => $result,
        ], 200);

    }
}
