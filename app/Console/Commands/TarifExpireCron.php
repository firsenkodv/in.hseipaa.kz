<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TarifExpireCron extends Command
{
    protected $signature = 'tarif:expire';

    protected $description = 'Сбрасывает тариф пользователям, у которых истёк срок действия';

    public function handle(): void
    {
        $count = User::query()
            ->whereNotNull('tarif_id')
            ->whereNotNull('tarif_expires_at')
            ->where('tarif_expires_at', '<=', now())
            ->update([
                'tarif_id'         => null,
                'tarif_expires_at' => null,
            ]);

        $this->info("Сброшено тарифов: {$count}");
    }
}
