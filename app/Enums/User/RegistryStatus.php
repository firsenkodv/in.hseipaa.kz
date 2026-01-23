<?php

namespace App\Enums\User;

enum RegistryStatus : int {
    case SPECIALIST = 1;
    case EXPERT = 2;
    case LEGALENTITY = 3;

    /**
     * Возвращает полное или сокращённое представление статуса.
     *
     * @param bool $short Вернуть сокращённый вариант?
     */
    public function text(bool $short = false): string
    {
        if ($short) {
            return match ($this) {
                self::SPECIALIST => 'Специалист',
                self::EXPERT => 'Эксперт',
                self::LEGALENTITY => 'Юр. лицо'
            };
        }

        return match ($this) {
            self::SPECIALIST => 'Специалисты',
            self::EXPERT => 'Эксперты',
            self::LEGALENTITY => 'Юридические лица'
        };
    }

    public function relation(): string
    {

        return match ($this) {
            self::SPECIALIST => 'UserSpecialist',
            self::EXPERT => 'UserExpert',
            self::LEGALENTITY => 'UserHuman'
        };
    }
}
