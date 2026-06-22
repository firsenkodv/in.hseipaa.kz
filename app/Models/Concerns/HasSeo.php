<?php

namespace App\Models\Concerns;

use App\Models\Seo;

trait HasSeo
{
    public static function bootHasSeo(): void
    {
        static::saved(function (self $model) {
            try {
                $model->syncSeoRecord();
            } catch (\Throwable $e) {
                // таблица seos ещё не создана — пропускаем
            }
        });
    }

    public function syncSeoRecord(): void
    {
        Seo::updateOrCreate(
            ['key' => $this->seoPrefix() . ':' . $this->id],
            [
                'model_class' => static::class,
                'label'       => $this->seoLabel(),
                'title'       => $this->metatitle ?? null,
                'description' => $this->description ?? null,
                'keywords'    => $this->keywords ?? null,
            ]
        );
    }

    public function seoPrefix(): string
    {
        $map = array_flip(config('seo.models', []));
        return $map[static::class] ?? \Illuminate\Support\Str::snake(class_basename(static::class));
    }

    public function seoLabel(): string
    {
        return $this->title ?? ((string) $this->id);
    }
}
