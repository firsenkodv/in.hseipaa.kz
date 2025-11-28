<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsefulItem extends Model
{
    protected $table = 'useful_items';

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
        'useful_subcategory_id',
        'files',
        'show',
        'faq_title',
        'faq'

    ];


    protected $casts = [
        'params' => 'collection',
        'show' => 'collection',
        'files' => 'collection',
        'faq' => 'collection',


    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(UsefulSubcategory::class, 'useful_subcategory_id')->where('published', 1);
    }

    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentCategoryAttribute()
    {
        $subcategory =  $this->subcategory;
        $category =  $subcategory->category;
        $section =  $category->useful;
        $a['link'] =  route('useful_category', ['useful' => $section->slug ,'category_slug' => $category->slug]);
        $a['title'] = $category->title;
        return (object) $a;
    }

    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentSubcategoryAttribute()
    {

        $subcategory =  $this->subcategory;
        $category =  $subcategory->category;
        $section =  $category->useful;
        $a['link'] =  route('useful_subcategory', ['useful' => $section->slug ,'category_slug' => $category->slug, 'subcategory_slug' => $subcategory->slug]);
        $a['title'] = $subcategory->title;
        return (object) $a;
    }

    /** метод написан для компонента teaser (получение правильных url) **/
    public function getUrlAttribute()
    {

        $subcategory =  $this->subcategory;
        $category =  $subcategory->category;
        $section =  $category->useful;
        return route('useful_item', ['useful' => $section->slug ,'category_slug' => $category->slug, 'subcategory_slug' => $subcategory->slug, 'item_slug' => $this->slug]);

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
