<?php

namespace App\Enums;

enum OrganizationEnum: string
{
    case TooHse  = 'too_hse';
    case IpHse   = 'ip_hse';
    case Niise   = 'niise';

    public function label(): string
    {
        return match($this) {
            self::TooHse => 'ТОО «Высшая школа экономики «Институт профессиональных бухгалтеров и аудиторов»',
            self::IpHse  => 'ИП «Высшая школа экономики «Институт профессиональных бухгалтеров и аудиторов»',
            self::Niise  => 'ТОО «Научно Исследовательский Институт Социологии и Экспертизы»',
        };
    }

    /** Размеры логотипа для email-писем: [width, height] в px */
    public function logoSize(): array
    {
        return match($this) {
            self::TooHse => [383, 57],
            self::IpHse  => [383, 57],
            self::Niise  => [245, 57],
        };
    }

    /** Путь относительно public/, используйте asset(logo()) в шаблонах */
    public function logo(): string
    {
        return match($this) {
            self::TooHse => '/storage/images/logos/logo-1.svg',
            self::IpHse  => '/storage/images/logos/logo-1.svg',
            self::Niise  => '/storage/images/logos/logo-3.svg',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value => $case->label()])
            ->all();
    }

    public static function fromLabel(string $label): ?self
    {
        return collect(self::cases())->first(fn(self $case) => $case->label() === $label);
    }

    public static function fromValueSafe(string $value): ?self
    {
        return self::tryFrom($value);
    }
}
