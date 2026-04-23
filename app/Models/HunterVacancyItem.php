<?php

namespace App\Models;

use App\Enums\HH\VacancyArchiveEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class HunterVacancyItem extends Model
{
    protected $table = 'hunter_vacancy_items';

    protected $fillable = [
        'user_id',              // Пользователь
        'title',                // Название
        'slug',                 // Ссылка (алиас)
        'subtitle',             // Подзаголовок
        'img',                  // Изображение
        'published',            // Опубликовано
        'sorting',              // Сортировка
        'hunter_category_id',   // Категория
        'user_city_id',         // Город
        'hunter_experience_id', // Опыт работы
        'price',                // Зарплата
        'logo',                 // Логотип
        'company',              // Компания
        'post',                 // Должность
        'desc',                 // Описание
        'must',                 // Требования
        'conditions',           // Условия
        'address',              // Адрес
        'email',                // Email
        'phone',                // Телефон
        'telegram',             // Telegram
        'whatsapp',             // WhatsApp
        'params',               // Дополнительные параметры
        'expired_at',           // Дата истечения
        'archive',              // Архив
    ];

    protected $casts = [
        'params' => 'collection',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HunterCategory::class, 'hunter_category_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(UserCity::class, 'user_city_id');
    }

    public function experience(): BelongsTo
    {
        return $this->belongsTo(HunterExperience::class, 'hunter_experience_id');
    }

    public function getCorrectedTelegramAttribute(): string
    {
        return (!$this->attributes['telegram']) ? '' : checkTelegram($this->attributes['telegram']);
    }

    public function getCorrectedWhatsappAttribute(): string
    {
        return (!$this->attributes['whatsapp']) ? '' : checkWhatsapp($this->attributes['whatsapp']);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->archive === VacancyArchiveEnum::ARCHIVE->value) {
                $model->published = 0;
            }
        });

        static::deleted(function ($model) {
            cache_clear();
            cache_clear_by_key('hunter-vacancy-slug-', $model->slug);
        });

        static::saved(function ($model) {
            cache_clear();
            cache_clear_by_key('hunter-vacancy-slug-', $model->slug);
        });
    }
}
