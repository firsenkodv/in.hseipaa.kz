<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteNew extends Model
{
    protected $table = 'site_news';

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


    public function item(): HasMany
    {
        return $this->hasMany(SiteNewItem::class)->where('published', 1)->orderBy('created_at', 'asc');
    }

    /** метод написан для получения правильного url категории **/
    public function getUrlAttribute(): string
    {
        return route('site_new_category', ['category_slug' => $this->slug]);

    }





    protected static function boot()
    {
        parent::boot();

        # Проверка данных  перед сохранением
        #  static::saving(function ($Moonshine) {   });


        static::created(function () {
            cache_clear();
        });

        static::updated(function () {
            cache_clear();
        });

        static::deleted(function () {
            cache_clear();
        });


    }
}
