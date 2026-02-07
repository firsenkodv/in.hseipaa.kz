<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarif extends Model
{
    protected $table = 'tarifs';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'price',
        'mpr',
        'tarif',
        'published',
        'params',
        'sorting',
        'user_id',
        'service_category_id',
        'service_item_id',
    ];

    protected $casts = [
        'params' => 'collection',
        'tarif' => 'collection',
    ];



    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'tarif_id');
    }

    public function service_category():BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function service_item():BelongsTo
    {
        return $this->belongsTo(ServiceItem::class, 'service_item_id');
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
