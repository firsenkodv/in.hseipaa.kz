<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HunterCategory extends Model
{
    protected $table = 'hunter_categories';

    protected $fillable = [
        'title',            // Название
        'slug',             // Ссылка (алиас)
        'subtitle',         // Подзаголовок
        'img',              // Изображение
        'desc',             // Описание
        'published',        // Опубликовано
        'sorting',          // Сортировка
    ];

    public function vacancies(): HasMany
    {
        return $this->hasMany(HunterVacancyItem::class);
    }

    public function resumes(): HasMany
    {
        return $this->hasMany(HunterResumeItem::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
            cache_clear_by_key('hunter-category-slug-', $model->slug);
        });

        static::saved(function ($model) {
            cache_clear();
            cache_clear_by_key('hunter-category-slug-', $model->slug);
        });
    }
}
