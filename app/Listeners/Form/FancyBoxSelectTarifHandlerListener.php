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
        if(isset($event->request['tarif'])) {
           $tarif =  Tarif::make()->tarif($event->request['tarif'])->toArray();

            $data['Имя пользователя:'] = ($event->request['username'])??' - ';
            $data['Телефон:'] = ($event->request['phone'])??' - ';
            $data['Email:'] = ($event->request['email'])??' - ';
            $data['Выбраны следующие опции'] = '';
            $data['Тариф:'] = $tarif['title'];
            $data['Опция:'] = $tarif['subtitle'];
            $data['Стоимость:'] = price($tarif['price']). ' '. config('currency.currency.KZT');

        } else {
            $data['Ошибка'] = config('site.constants.tarif_error'); //Тариф указан не корректно. Обратитесь в техническую поддержку
        }


        FancyBoxSelectTarifJob::dispatch($data); // Job


    }
}
