<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserFileQualification extends Model
{
    protected $table = 'user_file_qualifications';

    protected $fillable = [
        'title',
        'subtitle',
        'sorting',
        'params'
    ];

    protected $casts = [
        'params' => 'collection'
    ];

    public function User():BelongsToMany
    {
        return $this->belongsToMany(User::class);

    }
    public function UserFileQualification():BelongsToMany
    {
        return $this->belongsToMany(UserFileQualification::class)
            ->withPivot(['custom_documents']);

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
