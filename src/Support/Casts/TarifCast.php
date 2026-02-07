<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TarifCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return $value;

    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }

}
