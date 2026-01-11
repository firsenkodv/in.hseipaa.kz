<?php

namespace App\Listeners\Form;

use App\Events\Form\FancyBoxSelectTarifEvent;
use App\Jobs\Form\FancyBoxSelectTarifJob;
use App\Jobs\Form\FancyBoxSendingFromFormJob;
use Domain\Tarif\ViewModels\Tarif;
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

        $tarif_id = ($event->request['tarif'])??null;
        if(!is_null($tarif_id)) {
           $tarif =  Tarif::make()->tarif($tarif_id)->toArray();
            unset($event->request['tarif']);
            $event->request['Тариф'] = $tarif['title'];
            $event->request['Опция'] = $tarif['subtitle'];
            $event->request['Стоимость'] = price($tarif['price']). ' '. config('currency.currency.KZT');
        } else {
            $event->request['tarif'] = config('site.constants.tarif_error'); //Тариф указан не корректно. Обратитесь в техническую поддержку
        }


        FancyBoxSelectTarifJob::dispatch($event->request); // Job


    }
}
