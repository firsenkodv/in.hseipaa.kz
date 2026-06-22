<?php

namespace App\Console\Commands;

use App\Models\Seo;
use Illuminate\Console\Command;

class SeoSeedCommand extends Command
{
    protected $signature = 'seo:seed';

    protected $description = 'Populate seos table from all content models (copies metatitle/description/keywords)';

    public function handle(): int
    {
        $models = config('seo.models', []);

        foreach ($models as $prefix => $class) {
            $this->info("Processing {$class}...");
            $count = 0;

            $class::query()->each(function ($item) use (&$count) {
                try {
                    $item->syncSeoRecord();
                    $count++;
                } catch (\Throwable $e) {
                    $this->warn("  Skipped id={$item->id}: {$e->getMessage()}");
                }
            });

            $this->line("  → {$count} records");
        }

        // Статические страницы — только создаём запись-заглушку без model_class
        $pages = config('seo.pages', []);
        $this->info('Processing static pages...');
        foreach ($pages as $key => $label) {
            Seo::firstOrCreate(['key' => $key], ['label' => $label, 'model_class' => null]);
        }
        $this->line('  → ' . count($pages) . ' static pages (not managed through SEO resource)');

        $this->info('Done.');

        return self::SUCCESS;
    }
}
