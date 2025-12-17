<?php

namespace Domain\Tax\ViewModels;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class TaxViewModel
{

    use Makeable;


    public function items(): Collection|null
    {
        return Cache::rememberForever('tax_items', function () {

            return Tax::class::query()
                ->where('published', 1)
                ->orderBy('y', 'desc')
                ->get();


        });
    }

/** вывод календаря по slug  */
    public function item($slug): Model|null
    {

        // Генерируем уникальный ключ для каждого значения параметра
        $cacheKey = 'tax-item-slug-' . md5($slug);
        return Cache::remember($cacheKey, now()->addHour(), function () use ($slug) {
        $tax = Tax::class::query()
            ->where('published', 1)
            ->where('slug', $slug)
            ->first();

        if ($tax) {
          return  $this->usortMonth($tax);
        }

        return null;
        });
    }

/** вывод календаря по году  */
    public function itemY($y): Model|null
    {

        // Генерируем уникальный ключ для каждого значения параметра $y
        $cacheKey = 'tax-item-y-' . md5($y);
       return Cache::remember($cacheKey, now()->addHour(), function () use ($y) {

            $tax = Tax::class::query()
                ->where('published', 1)
                ->where('y', $y)
                ->first();

            if ($tax) {
                return $this->usortMonth($tax);
            }

            return null;
        });
    }


    /** Операции с пересчетом дат по возрастанию  */
    public function usortDate($data): array
    {

        $d = $data->toArray();

        /**  Универсальная сортировка по возрастанию дат **/
        usort($d, function ($a, $b) {
            return strtotime($a['json_date']) <=> strtotime($b['json_date']);
        });
        return $d;
    }

    public function usortMonth($tax):Model|null
    {
        if($tax) {
            if (count($tax['jan'])) {
                $tax['jan'] = $this->usortDate($tax['jan']);
            }
            if (count($tax['feb'])) {
                $tax['feb'] = $this->usortDate($tax['feb']);
            }
            if (count($tax['mar'])) {
                $tax['mar'] = $this->usortDate($tax['mar']);
            }
            if (count($tax['apr'])) {
                $tax['apr'] = $this->usortDate($tax['apr']);
            }
            if (count($tax['mai'])) {
                $tax['mai'] = $this->usortDate($tax['mai']);
            }
            if (count($tax['jun'])) {
                $tax['jun'] = $this->usortDate($tax['jun']);
            }
            if (count($tax['jul'])) {
                $tax['jul'] = $this->usortDate($tax['jul']);
            }
            if (count($tax['aug'])) {
                $tax['aug'] = $this->usortDate($tax['aug']);
            }
            if (count($tax['sept'])) {
                $tax['sept'] = $this->usortDate($tax['sept']);
            }
            if (count($tax['oct'])) {
                $tax['oct'] = $this->usortDate($tax['oct']);
            }
            if (count($tax['nov'])) {
                $tax['nov'] = $this->usortDate($tax['nov']);
            }
            if (count($tax['dec'])) {
                $tax['dec'] = $this->usortDate($tax['dec']);
            }
            return $tax;
        }
        return null;
    }

}


