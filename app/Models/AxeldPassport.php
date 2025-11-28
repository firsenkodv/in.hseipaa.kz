<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AxeldPassport extends Model
{
    protected $table = 'axeld_passports';

    protected $fillable = [
        'title',
        'desc',
        'video',
        'params',
        'sorting'
    ];


    protected $casts = [
        'params' => 'collection',
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
