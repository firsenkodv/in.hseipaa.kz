<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserUserFileQualification extends Model
{
    protected $table = 'user_user_file_qualification';

    protected $fillable = [
        'user_id',
        'user_file_qualification_id',
        'custom_documents',
    ];

    protected $casts = [
        'custom_documents' => 'collection'
    ];
/*    protected function casts(): array
    {
        return [
            'custom_documents' => 'json:unicode',
        ];
    }*/
    /**
     * Получить объект квалификации.
     */
    public function UserFileQualification():BelongsTo
    {
        return $this->belongsTo(UserFileQualification::class);
    }

    /**
     * Получить объект пользователя.
     */
    public function User():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
