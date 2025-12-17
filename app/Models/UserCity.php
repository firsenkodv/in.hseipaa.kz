<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCity extends Model
{
    protected $table = 'user_cities';

    protected $fillable = [
        'title',
        'subtitle',
        'sorting'
    ];

    protected $casts = [];

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'user_city_id');
    }

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
