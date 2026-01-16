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

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function () {
            cache_clear();
        });

        # Выполняем действия после сохранения
        static::saved(function () {
            cache_clear();
        });


    }

}
