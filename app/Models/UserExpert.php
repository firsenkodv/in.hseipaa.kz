<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserExpert extends Model
{
    protected $table = 'user_experts';

    protected $fillable = [
        'title',
        'subtitle',
        'sorting'
    ];

    protected $casts = [];

    public function User():BelongsToMany
    {
        return $this->belongsToMany(User::class);

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
