<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_number',
        'amount',
        'paid_amount',
        'desc',
        'params',
        'user_id',
        'tarif_id',
        'order_id',
        'currency',
        'order_status',
        'is_paid',
        'lang',
        'data',
    ];

    protected $casts = [
        'params'   => 'collection',
        'data'     => 'collection',
        'is_paid'  => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tarif(): BelongsTo
    {
        return $this->belongsTo(Tarif::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_paid ? 'Оплачено' : 'Не оплачено';
    }
}
