<?php

namespace App\Models;

use Domain\Manager\ViewModels\ManagerViewModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Log;

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
        'main',
        'super'
    ];


    protected function casts(): array
    {
        return [
            'params' => 'collection',
        ];
    }

    public function Rop(): BelongsTo
    {
        return $this->belongsTo(ROP::class, 'r_o_p_id');
    }

    /**
     * Переписки Manager с пользователями (кабинет)
     */
    public function cabinetConversations(): MorphMany
    {
        return $this->morphMany(CabinetConversation::class, 'staff');
    }

    /**
     * Все сообщения, отправленные Manager (кабинет)
     */
    public function sentCabinetMessages(): MorphMany
    {
        return $this->morphMany(CabinetMessage::class, 'sender');
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

            $new_manager = ManagerViewModel::make()->mainManager();
            if($model->main == 'MAIN') {
                $max_id = Manager::query()->max('id');
                $main_manager = Manager::query()->where('id', $max_id)->update(['main' => 'MAIN']);

            }
            // изменим всех пользователей
            User::query()
                ->where('manager_id', $model->id)
                ->Orwhere('manager_id', null)
                ->update(['manager_id' => $new_manager->id]);
            cache_clear();
        });


        # Проверка данных пользователя перед сохранением
        static::saving(function($model) {

        });

        # Выполняем действия после сохранения
        static::saved(function($model) {
            if($model->main == 'MAIN') {
                Manager::query()
                    ->where('main', 'MAIN')
                    ->where('id',  '!=' , $model->id )
                    ->update(['main' => 'MANAGER']);
            }
        });

    }
}
