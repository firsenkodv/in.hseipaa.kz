<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedFormData extends Model
{
    protected $table = 'saved_form_datas';
    protected $fillable = [
        'title',
        'subtitle',
        'email',
        'params',
        'sorting'
    ];


    protected $casts = [
        'params' => 'collection',
    ];

}
