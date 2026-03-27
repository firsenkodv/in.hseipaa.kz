<?php

namespace App\Enums\User;

enum MarkedDeleteEnum: int
{
    case NONE   = 0;
    case MARKED = 1;

    public function toString(): string
    {
        return match($this) {
            self::NONE   => 'Активный',
            self::MARKED => 'На удаление',
        };
    }

    public static function fromValue(int $value): self
    {
        return self::from($value);
    }
}
