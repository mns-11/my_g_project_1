<?php

namespace App\Enums;

enum CourseType: string
{
    case PRACTICAL = 'P';
    case THEORETICAL = 'T';

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
