<?php

declare(strict_types=1);

namespace ConstructionStages\Enums;

enum DurationUnit
{
    case HOURS;
    case DAYS;
    case WEEKS;

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->name] = $case->name;
        }

        return $array;
    }

    public static function createFrom($durationUnit)
    {
        return match ($durationUnit) {
            'HOURS' => DurationUnit::HOURS,
            'DAYS' => DurationUnit::DAYS,
            'WEEKS' => DurationUnit::WEEKS,
        };
    }
}
