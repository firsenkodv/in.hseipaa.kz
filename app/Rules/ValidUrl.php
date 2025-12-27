<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUrl implements ValidationRule
{
    private const PATTERN = '/^(https?):\/\/(?!(localhost|127\.0\.0\.1))\b[\p{L}\p{N}.-]+\.[\p{L}\p{N}-]{2,}/iu';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match(self::PATTERN, $value)) {
            $fail(':attribute должно быть корректным URL.');
        }
    }
}
