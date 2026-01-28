<?php

namespace App\Listeners\Form;

use App\Events\Form\FancyBoxSelectTarifEvent;
use App\Jobs\Form\FancyBoxSelectTarifJob;
use App\Jobs\Form\FancyBoxSendingFromFormJob;
use App\Models\Tarif;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class FancyBoxSelectTarifHandlerListener
{
    use EmailAddressCollector;
    use CreatorToken;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * сообщение
     */
    public function handle(FancyBoxSelectTarifEvent $event): void
    {
        if (!isset($event->request['tarif'])) {
            $data['Ошибка'] = config('site.constants.tarif_error'); // Тариф указан некорректно. Обратитесь в техподдержку
        } else {
            try {
                $tarif = Tarif::findOrFail($event->request['tarif']);

                $data = [
                    'Имя пользователя:'   => $event->request['username'] ?? '-',
                    'Телефон:'           => $event->request['phone'] ?? '-',
                    'Email:'              => $event->request['email'] ?? '-',
                    'Тариф:'             => $tarif->title,
                    'Опция:'             => $tarif->subtitle,
                    'Стоимость:'         => price($tarif->price) . ' ' . config('currency.currency.KZT'),
                ];
            } catch (\Exception $ex) {
                logErrors($ex);
                $data['Ошибка'] = 'Невозможно найти указанный тариф.';
            }
        }

        FancyBoxSelectTarifJob::dispatch($data);
    }
}
