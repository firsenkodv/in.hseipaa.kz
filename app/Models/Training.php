<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'trainings';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'sorting',
    ];
}
