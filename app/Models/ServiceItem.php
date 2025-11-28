<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceItem extends Model
{
    //service_items
    protected $table = 'service_items';

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
        'files',
        'service_category_id',
        'faq_title',
        'faq'

    ];

    protected $casts = [
        'params' => 'collection',
        'show' => 'collection',
        'files' => 'collection',
        'faq' => 'collection',


    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id')->where('published', 1);
    }


    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentCategoryAttribute()
    {
        $category = $this->category;
        $section = $category->service;
        $a['link'] = route('service_section', ['service' => $section->slug]);
        $a['title'] = $section->title;
        return (object)$a;
    }

    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentSubcategoryAttribute()
    {

        $category = $this->category;
        $section = $category->service;
        $a['link'] = route('service_category', ['service' => $section->slug, 'category_slug' => $category->slug]);
        $a['title'] = $category->title;
        return (object)$a;
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
