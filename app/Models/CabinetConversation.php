<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CabinetConversation extends Model
{
    protected $fillable = [
        'user_id',
        'staff_type',
        'staff_id',
    ];

    /**
     * Пользователь — одна сторона переписки
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Сотрудник — ROP или Manager (полиморфная связь)
     */
    public function staff(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Все сообщения переписки
     */
    public function messages(): HasMany
    {
        return $this->hasMany(CabinetMessage::class);
    }
}
