<?php

namespace Domain\Tarif\ViewModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class Tarif
{
    use Makeable;

    public function tarifs()
    {
        return Cache::rememberForever('tarifs', function () {

          return  \App\Models\Tarif::query()
              ->where('published', 1)
              ->orderBy('sorting', 'desc')
              ->get();
        });


    }
    public function tarif($id):model | null
    {

          return  \App\Models\Tarif::find($id);


    }

}
