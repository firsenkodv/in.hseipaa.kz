<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ROP extends Model
{
    protected $table = 'r_o_p_s';

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
    ];


    protected function casts(): array
    {
        return [
            'params' => 'collection',
        ];
    }

    public function manager(): HasMany
    {
        return $this->hasMany(Manager::class,);
    }



    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
        });

    }
}
