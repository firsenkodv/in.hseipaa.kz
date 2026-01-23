<?php

namespace App\Enums\User;

enum Status : int {
    case INDIVIDUAL = 1;
    case LEGALENTITY = 2;

    /**
     * Возвращает полное или сокращённое представление статуса.
     *
     * @param bool $short Вернуть сокращённый вариант?
     */
    public function text(bool $short = false): string
    {
        if ($short) {
            return match ($this) {
                self::INDIVIDUAL => 'Физ. лицо',
                self::LEGALENTITY => 'Юр. лицо'
            };
        }

        return match ($this) {
            self::INDIVIDUAL => 'Физическое лицо',
            self::LEGALENTITY => 'Юридическое лицо'
        };
    }
}
