<?php

namespace Domain\Payment\ViewModels;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentViewModel
{
    private string $urlRegister = 'https://securepayments.berekebank.kz/payment/rest/register.do';
    private string $urlStatus   = 'https://securepayments.berekebank.kz/payment/rest/getOrderStatusExtended.do';
    private string $userName;
    private string $password;
    private string $language = 'ru';
    private int    $currency = 398;

    public function __construct()
    {
        $this->userName = config('bereke.username');
        $this->password = config('bereke.password');
    }

    public static function make(): static
    {
        return new static();
    }

    /**
     * Шаг 1: регистрация заказа в банке.
     * Сохраняет Payment со статусом 0, возвращает formUrl для редиректа.
     */
    public function registerOrder(int $tarifId, int $tarifPrice, int $userId): ?string
    {
        $orderNumber = $this->generateUniqueOrderNumber();

        $payload = [
            'userName'    => $this->userName,
            'password'    => $this->password,
            'orderNumber' => $orderNumber,
            'amount'      => $this->toTiiyn($tarifPrice),
            'currency'    => $this->currency,
            'returnUrl'   => route('cabinet_payment_return'),
            'description' => 'Оплата тарифа #' . $tarifId,
            'language'    => $this->language,
        ];

        $response = $this->curlPost($this->urlRegister, $payload);

        if (!$response || !isset($response->formUrl)) {
            Log::error('BerekeBank register.do error', [
                'response' => $response,
                'tarif_id' => $tarifId,
            ]);
            return null;
        }

        Payment::create([
            'order_number' => $orderNumber,
            'amount'       => $this->toTiiyn($tarifPrice),
            'desc'         => 'Тариф #' . $tarifId,
            'user_id'      => $userId,
            'tarif_id'     => $tarifId,
            'order_id'     => $response->orderId ?? null,
            'currency'     => (string) $this->currency,
            'order_status' => 0,
            'is_paid'      => false,
            'lang'         => $this->language,
        ]);

        return $response->formUrl;
    }

    /**
     * Шаг 2: проверка статуса по orderId после возврата с банка.
     */
    public function checkOrderStatus(string $orderId): ?object
    {
        $payload = [
            'userName' => $this->userName,
            'password' => $this->password,
            'orderId'  => $orderId,
            'language' => $this->language,
        ];

        return $this->curlPost($this->urlStatus, $payload);
    }

    /**
     * Шаг 3: обновление записи платежа после получения статуса.
     */
    public function finalizeOrder(string $orderId, object $bankResponse): bool
    {
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return false;
        }

        $isPaid      = ((int) $bankResponse->orderStatus) === 2;
        $paidAmount  = isset($bankResponse->amount) ? (int) round($bankResponse->amount / 100) : null;

        $payment->update([
            'order_status' => (int) $bankResponse->orderStatus,
            'paid_amount'  => $paidAmount,
            'is_paid'      => $isPaid,
            'data'         => json_encode($bankResponse),
        ]);

        return $isPaid;
    }

    public function userPayments(int $userId)
    {
        return Payment::where('user_id', $userId)
            ->with('tarif')
            ->latest()
            ->get();
    }

    private function generateUniqueOrderNumber(): string
    {
        do {
            $code = (string) ((time() * 1000) + random_int(100, 999));
        } while (Payment::where('order_number', $code)->exists());

        return $code;
    }

    private function toTiiyn(int|float $amount): int
    {
        return (int) round($amount * 100);
    }

    private function curlPost(string $url, array $data): ?object
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 30,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response ? json_decode($response) : null;
    }
}
