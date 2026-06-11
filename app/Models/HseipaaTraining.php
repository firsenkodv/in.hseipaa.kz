<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// PRODUCTION: убедиться, что подключение 'hseipaa' в config/database.php
// ссылается на правильный хост и БД боевого Сайта 1 (hseipaa.test).
class HseipaaTraining extends Model
{
    protected $connection = 'hseipaa';
    protected $table = 'trainings';
    public $timestamps = false;
}
