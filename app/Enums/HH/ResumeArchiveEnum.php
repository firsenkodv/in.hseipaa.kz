<?php

namespace App\Enums\HH;

enum ResumeArchiveEnum: string
{
    case ARCHIVE     = 'ARCHIVE';
    case NOTARCHIVED = 'NOTARCHIVED';

    public function toString(): string
    {
        return match ($this) {
            self::ARCHIVE     => 'В архиве',
            self::NOTARCHIVED => 'Активно',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ARCHIVE     => 'gray',
            self::NOTARCHIVED => 'green',
        };
    }
}
