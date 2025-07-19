<?php

namespace App\Enums;

enum AttendanceStatus: int
{
    case PRESENT = 1;
    case LATE = 2;
    case ABSENT = 3;
    case EXCUSED = 4;

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
