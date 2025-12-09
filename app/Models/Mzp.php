<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mzp extends Model
{
    protected $table = 'mzps';

    protected $fillable = [
        'title',
        'subtitle',
        'menu',
        'slug',
        'published',
        'text',
        'desc',
        'params',
        'sorting',
        'metatitle',
        'description',
        'keywords',
        'y',
        'presently',
        'faq_title',
        'faq',
        'td_1',
        'td_2',
        'td_3',
        'td_4',
        'td_5',
        'td_date_5',
    ];

    protected $casts = [
        'params' => 'collection',
        'faq' => 'collection',
        'td_1' => 'collection',
        'td_2' => 'collection',
        'td_3' => 'collection',
        'td_4' => 'collection',
        'td_5' => 'collection',


    ];


    protected static function boot()
    {
        parent::boot();

        # Проверка данных  перед сохранением
        #  static::saving(function ($Moonshine) {   });


        static::created(function () {
            cache_clear();
        });

        static::updated(function () {
            cache_clear();
        });

        static::deleted(function () {
            cache_clear();
        });


    }
}
