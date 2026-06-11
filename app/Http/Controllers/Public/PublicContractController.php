<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\Contract\ContractSignedMail;
use App\Models\Contract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class PublicContractController extends Controller
{
    public function show(string $token)
    {
        $contract = Contract::where('public_token', $token)->firstOrFail();

        return view('public.contract', compact('contract', 'token'));
    }

    public function sign(string $token, \Illuminate\Http\Request $request): JsonResponse
    {
        $contract = Contract::with('user.Manager')
            ->where('public_token', $token)
            ->where('is_signed', false)
            ->firstOrFail();

        $contract->update(['is_signed' => true]);

        if ($contract->email) {
            Mail::to($contract->email)->queue(new ContractSignedMail($contract, $request->ip()));
        }

        return response()->json(['signed' => true]);
    }
}
