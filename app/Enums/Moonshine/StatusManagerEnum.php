<?php

namespace App\Enums\Moonshine;

enum StatusManagerEnum :string
{

    case MAIN = 'MAIN';
    case MANAGER = 'MANAGER';

   public function toString(): ?string
    {
        return match ($this) {
            self::MAIN => 'По умолчанию',
            self::MANAGER => 'Менеджер',
        };
    }
    public function getColor(): ?string
    {
        return match ($this) {
            self::MAIN => 'secondary',
            self::MANAGER => 'gray',
        };
    }
}
