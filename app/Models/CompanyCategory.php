<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyCategory extends Model
{
    protected $table = 'company_categories';

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
        return $this->hasMany(CompanyItem::class)->where('published', 1)->orderBy('sorting', 'asc');
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
