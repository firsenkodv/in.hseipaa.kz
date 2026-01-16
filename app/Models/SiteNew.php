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



    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
            cache_clear_by_key('site-new-category-slug-', $model->slug);
        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
            cache_clear_by_key('site-new-category-slug-', $model->slug);

        });


    }


}
