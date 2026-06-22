<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollAnswer extends Model
{
    protected $fillable = [
        'poll_response_id',
        'question_index',
        'question_text',
        'answer',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(PollResponse::class, 'poll_response_id');
    }
}
