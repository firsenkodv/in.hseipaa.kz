<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserLanguage extends Model
{
    protected $table = 'user_languages';

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
