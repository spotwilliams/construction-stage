<?php

declare(strict_types=1);

namespace ConstructionStages\Services\DurationCalculators;

use ConstructionStages\Enums\DurationUnit;

class DurationCalculationService
{
    /**
     * Calculates the duration between two dates using the provided duration unit.
     *
     * @param \DateTime $startDate The start date.
     * @param \DateTime $endDate The end date.
     * @param DurationUnit $durationUnit The duration unit to use.
     * @return int The duration between the two dates.
     */
    public static function calculate(\DateTime $startDate, \DateTime $endDate, DurationUnit $durationUnit): int
    {
        return self::getCalculator($durationUnit)->calculate($startDate, $endDate);
    }

    /**
     * Gets the calculator for the specified duration unit.
     *
     * @param DurationUnit $unit The duration unit.
     * @return Calculator The calculator for the specified duration unit.
     */
    private static function getCalculator(DurationUnit $unit): Calculator
    {
        $class = match ($unit) {
            DurationUnit::HOURS => DurationByHours::class,
            DurationUnit::DAYS => DurationByDays::class,
            DurationUnit::WEEKS => DurationByWeeks::class,
            default => DurationByDays::class

        };
        return new $class;
    }
}
