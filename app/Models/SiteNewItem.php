<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteNewItem extends Model
{
    protected $table = 'site_new_items';

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
        'files',
        'site_new_id',
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
        return $this->belongsTo(SiteNew::class, 'site_new_id')->where('published', 1);
    }


    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentCategoryAttribute()
    {

        $a['link'] =  route('site_new_categories');
        $a['title'] = config2('moonshine.new.title');
        return (object) $a;
    }

    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentSubcategoryAttribute()
    {

        $category =  $this->category;
        $a['link'] =  route('site_new_category', ['category_slug' => $category->slug]);
        $a['title'] = $category->title;
        return (object) $a;
    }

    /** метод написан для получения правильного url новости **/
    public function getUrlAttribute(): string
    {
        $category =  $this->category;
        return route('site_new_item', ['category_slug' => $category->slug, 'item_slug' => $this->slug]);

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

