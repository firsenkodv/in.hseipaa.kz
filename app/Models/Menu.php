<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'menus';

    protected $fillable = [
        'title',
        'col1',
        'col2',
        'col3',
        'col4',
        'params',
        'published',


    ];

    protected $casts = [
        'params' => 'collection',
        'col1' => 'collection',
        'col2' => 'collection',
        'col3' => 'collection',
        'col4' => 'collection',

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
