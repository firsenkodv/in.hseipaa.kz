<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxes';

    protected $fillable = [
        'title',
        'subtitle',
        'menu',
        'slug',
        'published',
        'jan',
        'feb',
        'mar',
        'apr',
        'mai',
        'jun',
        'jul',
        'aug',
        'sept',
        'oct',
        'nov',
        'dec',
        'text',
        'params',
        'sorting',
        'metatitle',
        'description',
        'keywords',
        'y',
        'presently',
        'faq_title',
        'faq'
    ];

    protected $casts = [
        'params' => 'collection',
        'jan' => 'collection',
        'feb' => 'collection',
        'mar' => 'collection',
        'apr' => 'collection',
        'mai' => 'collection',
        'jun' => 'collection',
        'jul' => 'collection',
        'aug' => 'collection',
        'sept' => 'collection',
        'oct' => 'collection',
        'nov' => 'collection',
        'dec' => 'collection',
        'faq' => 'collection',


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
