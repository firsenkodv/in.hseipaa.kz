<?php

namespace App\Services;

use Support\Traits\Makeable;

class CheckCounterParty
{
use Makeable;

    public function checkBin($bin) :array
    {
        /**
         * API KEY
         * Проверка бина (проверка контрагента)
         */
        $key = config2('moonshine.setting.counterparty_id');

        //  $bin = '211140006711';
        $url = 'https://data.egov.kz/api/v4/gbd_ul/v1?apiKey='. $key .'&source={"size":1,"query":{"bool":{"must":[{"match":{"bin":"'.$bin.'"}}]}}}';


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        $data=json_decode($html,true);
        $org=(isset($data[0])) ? $data[0] : null;


        /*if ($org){
            echo "<pre>";
            print_r($org);

        }*/

        $query ='{"query":"query($filter: RnuFiltersInput){Rnu(filter: $filter){id,pid,supplierNameRu,supplierNameKz,supplierBiin,supplierInnunp,startDate,endDate,supplier,katoList}}","variables":{"filter":{"supplierBiin":"'.$bin.'"}}}';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://ows.goszakup.gov.kz/v3/graphql",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 50,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER =>false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer b322cddb0c13202374bc2e46a77558e1",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $response=json_decode($response,true);

        /*
        echo "<pre>";
        print_r($response);*/

        $url='https://stat.gov.kz/api/juridical/counter/api/?bin='.$bin.'&lang=ru';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        $data=json_decode($html,true);

        $array1 = $org;
        $array2 = (isset($response)) ? $response : null;
        $array3 = (isset($data['obj'])) ? $data['obj'] : null;

        $result =  [];

        //  Статусы
        //1 Надежный
        //2 Недостаточно информации для надежности
        //3 Ненадежный
        //4 Нет


        if($array1) {
            $result['status'] = 1;
            if (isset($array1['nameru'])) {
                $result['nameru'] = $array1['nameru']; /* название */
            } else {
                $result['status'] = 2;
            }
            if (isset($array1['bin'])) {
                $result['bin'] = $array1['bin'];  /*бин*/
            } else {
                $result['status'] = 2;
            }
            if (isset($array1['namekz'])) {
                $result['namekz'] = $array1['namekz']; /* название на казахском */
            } else {
                $result['status'] = 2;
            }
            if (isset($array1['addressru'])) {
                $result['addressru'] = $array1['addressru'];  /*юридический адрес */
            } else {
                $result['status'] = 2;
            }
            if (isset($array1['director'])) {
                $result['director'] = $array1['director']; /* руководитель */
            } else {
                $result['status'] = 2;
            }
            if (isset($array1['okedru'])) {
                $result['okedru'] = $array1['okedru']; /* вид деятельности*/
            } else if(isset($array3['okedName'])) {
                $result['okedru'] =  $array3['okedName']; /* вид деятельности*//* проверяем два раза*/
            }
            else {
                $result['status'] = 2;
            }
            if (isset($array3['okedCode'])) {
                $result['okedCode'] = $array3['okedCode']; /* oked ОКЕД */
            } else {
                $result['status'] = 2;
            }
            if (isset($array3['krpCode'])) {
                $result['krpCode'] = $array3['krpCode']; /* krp КРП */
            } else {
                $result['status'] = 2;
            }

            if (isset($array3['krpName'])) {
                $result['krpName'] = $array3['krpName']; /* krpName Малые предприятия */
            } else {
                $result['status'] = 2;
            }
            if (isset($array3['katoCode'])) {
                $result['katoCode'] = $array3['katoCode']; /* КАТО  */
            } else {
                $result['status'] = 2;
            }

            if (isset($array2['data']['Rnu'][0]['supplierNameRu'])) {
                $result['status'] = 3;
            }
        } else {
            $result['status'] = 4;
        }

        return $result;

    }
}
