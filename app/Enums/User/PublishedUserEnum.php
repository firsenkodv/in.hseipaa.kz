<?php

namespace App\Enums\User;

enum PublishedUserEnum: int
{
    case PUBLISHED   = 1;
    case BLOCKED = 0;

    public function toString(): string
    {
        return match($this) {
            self::PUBLISHED   => 'Опубликован',
            self::BLOCKED => 'Заблокирован',
        };
    }

    public static function fromValue(int $value): self
    {
        return self::from($value);
    }

    public function class(): string
    {

        return match ($this) {
            self::PUBLISHED => 'green',
            self::BLOCKED => 'red',
        };
    }
}
