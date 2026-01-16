<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    protected $table = 'service_categories';

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

        'temp_title',
        'temp_img',
        'temp_desc',
        'temp_price',

        'metatitle',
        'description',
        'keywords',
        'script_published',
        'script',
        'show',
        'service_id',
        'faq_title',
        'faq'

    ];


    protected $casts = [
        'params' => 'collection',
        'show' => 'collection',
        'faq' => 'collection',


    ];

    protected $with = ['tarif'];

    public function service(): BelongsTo {
        return $this->belongsTo(Service::class, 'service_id')->where('published', 1);
    }

    public function item(): HasMany
    {
        return $this->hasMany(ServiceItem::class)->where('published', 1)->orderBy('sorting', 'asc');
    }


    public function tarif():BelongsToMany
    {
        return $this->belongsToMany(Tarif::class)->where('published', 1)->orderBy('sorting', 'desc');
    }


    /** метод (получение правильных url) **/
    public function getUrlAttribute()
    {
        $section = $this->service;
        return route('service_category', ['service' => $section->slug, 'category_slug' => $this->slug]);
    }





    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
            cache_clear_by_key('service-category-slug-', $model->slug);
            cache_clear_by_key('service-category-id-', $model->slug);
        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
            cache_clear_by_key('service-category-slug-', $model->slug);
            cache_clear_by_key('service-category-id-', $model->slug);
        });


    }
}
