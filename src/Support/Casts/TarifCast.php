<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TarifCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes):bool
    {
        return !is_null($value);

    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }

}
