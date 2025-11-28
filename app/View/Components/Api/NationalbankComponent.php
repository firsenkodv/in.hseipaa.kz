<?php

namespace App\View\Components\Api;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NationalbankComponent extends Component
{

    public array $currencies = [];
    public array $errors = [];

    public function __construct()
    {
        $this->cource();
    }

    public function cource(): void
    {

        /*        $url = 'https://nationalbank.kz/rss/get_rates.cfm?fdate=' . date("d.m.Y");
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $html = curl_exec($ch);
                curl_close($ch);

                $xml = simplexml_load_string($html);*/


        $url = 'https://nationalbank.kz/rss/get_rates.cfm?fdate=' . date("d.m.Y");
        $ch = curl_init($url);

// Настройки cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Возвращаем результат функцией curl_exec()
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Отключаем проверку SSL-сертификата сервера
        curl_setopt($ch, CURLOPT_HEADER, false); // Не включаем заголовки HTTP

// Выполняем запрос
        $html = curl_exec($ch);

        if ($html === false) {
           $this->errors['error_curl'] =  "Ошибка cURL: " . curl_error($ch);
        } else {
            // Загружаем строку в объект SimpleXML
            $xml = @simplexml_load_string($html);

            if (!$xml) { // Если произошла ошибка парсинга XML
                $this->errors['error_loading'] =  "Ошибка загрузки XML.";
            }
        }


        curl_close($ch);


        if (isset($xml)) {

            $xml_array = unserialize(serialize(json_decode(json_encode((array)$xml), 1)));

            foreach ($xml_array['item'] as $item) {

                if ($item['title'] == "USD") {
                    $this->currencies['USD'] = $item['description'];
                }
                if ($item['title'] == "EUR") {
                    $this->currencies['EUR'] = $item['description'];
                }
                if ($item['title'] == "RUB") {
                    $this->currencies['RUB'] = $item['description'];
                }
            }
        }


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.api.nationalbank-component');
    }
}
