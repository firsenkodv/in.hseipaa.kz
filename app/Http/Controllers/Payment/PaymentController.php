<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Domain\Payment\ViewModels\PaymentViewModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    /**
     * Инициация платежа: регистрирует заказ в банке и редиректит на страницу оплаты.
     */
    public function initPayment(Request $request): RedirectResponse
    {
        $tarifId = (int) $request->get('tarif_id');
        $tarif   = Tarif::where('id', $tarifId)->where('published', 1)->first();

        if (!$tarif) {
            flash()->alert(config('message_flash.alert.bereke_error'));
            return redirect()->route('cabinet_pricing');
        }

        $formUrl = PaymentViewModel::make()->registerOrder(
            tarifId:    $tarif->id,
            tarifPrice: (int) $tarif->price,
            userId:     auth()->id(),
        );

        if (!$formUrl) {
            flash()->alert(config('message_flash.alert.bereke_error'));
            return redirect()->route('cabinet_pricing');
        }

        return redirect($formUrl);
    }

    /**
     * Callback-редирект от банка после оплаты (?orderId=...).
     */
    public function returnPaymentOrder(Request $request): RedirectResponse
    {
        $orderId = $request->get('orderId');

        if (!$orderId) {
            flash()->alert(config('message_flash.alert.bereke_status_error'));
            return redirect()->route('cabinet_pricing');
        }

        $bankResponse = PaymentViewModel::make()->checkOrderStatus($orderId);

        if (!$bankResponse) {
            flash()->alert(config('message_flash.alert.bereke_status_error'));
            return redirect()->route('cabinet_pricing');
        }

        $isPaid = PaymentViewModel::make()->finalizeOrder($orderId, $bankResponse);

        if ($isPaid) {
            flash()->info(config('message_flash.info.bereke_info'));
        } else {
            flash()->alert(config('message_flash.alert.bereke_status_error'));
        }

        return redirect()->route('cabinet_pricing');
    }
}
