<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CabinetMessage extends Model
{
    protected $fillable = [
        'cabinet_conversation_id',
        'sender_type',
        'sender_id',
        'body',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    /**
     * Переписка, к которой относится сообщение
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(CabinetConversation::class);
    }

    /**
     * Отправитель — User, ROP или Manager (полиморфная связь)
     */
    public function sender(): MorphTo
    {
        return $this->morphTo();
    }
}
