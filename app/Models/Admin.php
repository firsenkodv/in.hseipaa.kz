<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'username',
        'password',
        'email',
        'phone',
        'avatar',
        'instagram',
        'whatsapp',
        'social',
        'website',
        'params',
        'super'
    ];

    protected function casts(): array
    {
        return [
            'params' => 'collection',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
        });

        static::saved(function ($model) {
            cache_clear();
        });
    }
}
