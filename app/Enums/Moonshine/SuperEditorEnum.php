<?php

namespace App\Enums\Moonshine;

enum SuperEditorEnum :string
{

    case SUPEREDITOR = 'SUPEREDITOR';
    case DEFAULT = 'DEFAULT';

   public function toString(bool $short = false): ?string
    {

        if ($short) {
            return match ($this) {
                self::SUPEREDITOR => 'Вы можете редактировать',
                self::DEFAULT => 'Вы не можете редактировать',
            };
        }

        return match ($this) {
            self::SUPEREDITOR => 'Редактор пользователей',
            self::DEFAULT => 'Просмотр пользователей',
        };
    }
    public function getColor(): ?string
    {
        return match ($this) {
            self::SUPEREDITOR => 'secondary',
            self::DEFAULT => 'gray',
        };
    }

    /**
     * Получить массив всех значений в формате key-value
     */
    public static function toArray(): array
    {
        return array_map(function ($case) {
            return [
                'key' => $case->value,
                'value' => $case->toString()
            ];
        }, self::cases());
    }

    /**
     * Проверить, существует ли значение
     */
    public static function isValid(string $value): bool
    {
        return !is_null(self::tryFrom($value));
    }

    /**
     * Получить enum по значению или вернуть null
     */
    public static function fromValue(string $value): ?self
    {
        return self::tryFrom($value);
    }

}
