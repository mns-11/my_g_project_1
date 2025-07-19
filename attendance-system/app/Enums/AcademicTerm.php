<?php

namespace App\Enums;

enum AcademicTerm: string
{
    case ONE = 'one';
    case TWO = 'two';

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
