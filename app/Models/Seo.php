<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = ['key', 'model_class', 'label', 'title', 'description', 'keywords'];

    public function scopeIncomplete(Builder $query): Builder
    {
        return $query
            ->whereNotNull('model_class')
            ->where(function (Builder $q) {
                $q->whereNull('title')->orWhere('title', '')
                  ->orWhereNull('description')->orWhere('description', '')
                  ->orWhereNull('keywords')->orWhere('keywords', '');
            });
    }
}
