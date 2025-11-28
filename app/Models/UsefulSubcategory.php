<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsefulSubcategory extends Model
{
    protected $table = 'useful_subcategories';

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
        'useful_category_id',
        'show',
        'faq_title',
        'faq'
    ];


    protected $casts = [
        'params' => 'collection',
        'show' => 'collection',
        'faq' => 'collection',


    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(UsefulCategory::class, 'useful_category_id')->where('published', 1);
    }

    public function item(): HasMany
    {
        return $this->hasMany(UsefulItem::class)->where('published', 1)->orderBy('sorting', 'asc');
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
