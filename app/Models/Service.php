<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_desc',
        'img',
        'desc',
        'img2',
        'desc2',

        'published',
        'params',
        'sorting',

        'metatitle',
        'description',
        'keywords',
        'script_published',
        'script',
        'show',
        'faq_title',
        'faq'

    ];


    protected $casts = [
        'params' => 'collection',
        'show' => 'collection',
        'faq' => 'collection',


    ];

    public function category(): HasMany
    {
        return $this->hasMany(ServiceCategory::class)->where('published', 1)->orderBy('sorting', 'asc');
    }



    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
        });


    }
}
