<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manager extends Model
{

    protected $table = 'managers';

    protected $fillable = [
        'username',
        'password',
        'email',
        'phone',
        'avatar',
        'instagram',
        'whatsapp',
        'telegram',
        'social',
        'website',
        'params',
        'r_o_p_id',
        'main'
    ];


    protected function casts(): array
    {
        return [
            'params' => 'collection',
        ];
    }

    public function rop(): BelongsTo
    {
        return $this->belongsTo(ROP::class, 'r_o_p_id');
    }



/*    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }*/



    /**
     * Выводим реальный телеграм
     */
    public function getCorrectedTelegramAttribute(): ?string
    {
        return (!$this->attributes['telegram'])? '' : checkTelegram($this->attributes['telegram']);

    }


    /**
     * Выводим  whatsapp
     */

    public function getCorrectedWhatsappAttribute(): string
    {
        return (!$this->attributes['whatsapp'])? '' : checkWhatsapp($this->attributes['whatsapp']);
    }

    /**
     * Выводим  instagram
     */

    public function getCorrectedInstagramAttribute(): string
    {
        return (!$this->attributes['instagram'])? '' : checkInstagram($this->attributes['instagram']);

    }


    protected static function boot():void
    {
        parent::boot();

        # Выполняем действия во время удаления
        static::deleting(function ($model) {
            if($model->main == 'MAIN') {
                // все ставим MANAGER
                Manager::query()
                    ->where('main', 'MAIN')
                    ->update(['main' => 'MANAGER']);
            }
        });

        # Выполняем действия после удаления
        static::deleted(function ($model) {
            $max_id = Manager::query()->max('id');
            Manager::query()->where('id', $max_id)->update(['main' => 'MAIN']);
            cache_clear();
        });


        # Выполняем действия после сохранения
        static::saved(function($model){
            if($model->main == 'MAIN') {
                Manager::query()
                    ->where('main', 'MAIN')
                    ->where('id',  '!=' , $model->id )
                    ->update(['main' => 'MANAGER']);
            }
        });

    }
}
