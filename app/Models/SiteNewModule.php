<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteNewModule extends Model
{
    protected $table = 'site_new_modules';
    protected $fillable = [
        'title',
        'img',
        'link',
        'params',
        'site_new_id',
        'site_new_item_id',
        'sorting',
        'faq_title',
        'faq'
    ];

    protected $casts = [
        'params' => 'collection',
        'faq' => 'collection',

    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(SiteNew::class, 'site_new_id')->where('published', 1);
    }

        public function item(): BelongsTo
    {
        return $this->belongsTo(SiteNewItem::class, 'site_new_item_id')->where('published', 1);
    }

    protected static function boot(): void
    {
        parent::boot();

        # Проверка данных перед сохранением
        static::saving(function ($mod) {

            $a['site_new_id'] = $mod->site_new_id;
            $a['site_new_item_id'] = $mod->site_new_item_id;

            foreach ($a as $key => $value) {
                if (!is_null($value)) {
                    $mod->site_new_id = null;
                    $mod->site_new_item_id = null;
                    $mod->$key = $value;
                   // return true;
                }
            }
            cache_clear();

        });


        static::deleted(function ($model) {
            cache_clear();

        });

        # Выполняем действия после сохранения
        static::saved(function ($model) {
            cache_clear();
        });


    }
}
