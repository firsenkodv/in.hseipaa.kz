<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyItem extends Model
{
    protected $table = 'company_items';

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
        'company_category_id',
        'faq_title',
        'faq'

    ];

    protected $casts = [
        'params' => 'collection',
        'show' => 'collection',
        'files' => 'collection',
        'faq' => 'collection',


    ];

    public function category(): BelongsTo {
        return $this->belongsTo(CompanyCategory::class, 'company_category_id')->where('published', 1);
    }


    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentCategoryAttribute()
    {
        $a['link'] =  route('company_categories');
        $a['title'] = config2('moonshine.company.title');
        return (object) $a;
    }

    /** метод написан для компонента teaser (получение правильных url) **/
    public function getParentSubcategoryAttribute()
    {
        $category =  $this->category;
        $a['link'] =  route('company_category', ['category_slug' => $category->slug]);
        $a['title'] = $category->title;
        return (object) $a;
    }



    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            cache_clear();
            cache_clear_by_key('company-item-slug-', $model->slug);
        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
            cache_clear_by_key('company-item-slug-', $model->slug);
        });


    }
}
