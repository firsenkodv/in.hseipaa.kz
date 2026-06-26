<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsefulSubcategory extends Model
{
    use HasSeo;

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

    public function getUrlAttribute(): string
    {
        $category = $this->category;
        $useful   = $category->useful;
        return route('useful_subcategory', ['useful' => $useful->slug, 'category_slug' => $category->slug, 'subcategory_slug' => $this->slug]);
    }

    public function item(): HasMany
    {
        return $this->hasMany(UsefulItem::class)->where('published', 1)->orderBy('sorting', 'asc');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function () {
            cache_clear();
        });

        # Выполняем действия после сохранения
        static::saved(function () {
            cache_clear();
        });


    }
}
