<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contract_number',
        'full_name',
        'email',
        'phone',
        'discipline',
        'price',
        'currency',
        'hours',
        'date_start',
        'date_end',
        'is_signed',
        'public_token',
        'organizations',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'date',
            'date_end'   => 'date',
            'price'      => 'decimal:2',
            'hours'      => 'integer',
            'is_signed' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $contract) {
            if (!empty($contract->contract_number)) {
                return;
            }

            $lastSeq = self::whereYear('created_at', now()->year)
                ->whereNotNull('contract_number')
                ->get()
                ->map(fn($c) => (int) explode('/', $c->contract_number)[0])
                ->max() ?? 0;

            $contract->contract_number = sprintf('%02d/%s/%s', $lastSeq + 1, now()->format('m'), now()->format('y'));
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
