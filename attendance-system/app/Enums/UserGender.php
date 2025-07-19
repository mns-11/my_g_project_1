<?php

namespace App\Enums;

enum UserGender: string
{
    case Male = 'M';
    case Female = 'F';

    public static function values(): array
    {
        return array_map(fn($enum) => $enum->value, self::cases());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
