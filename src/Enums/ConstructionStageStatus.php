<?php

declare(strict_types=1);

namespace ConstructionStages\Enums;

enum ConstructionStageStatus
{
    case NEW;
    case PLANNED;
    case DELETED;

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->name] = $case->name;
        }

        return $array;
    }
}
