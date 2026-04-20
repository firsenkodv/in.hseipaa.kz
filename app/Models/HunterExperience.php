<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HunterExperience extends Model
{
    protected $table = 'hunter_experiences';

    protected $fillable = [
        'title',            // Название
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

        static::deleted(function () {
            cache_clear();
        });

        static::saved(function () {
            cache_clear();
        });
    }
}
