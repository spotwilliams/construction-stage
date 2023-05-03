<?php

declare(strict_types=1);

namespace ConstructionStages\Services\DurationCalculators;

use ConstructionStages\Enums\DurationUnit;

interface Calculator
{
    /**
     * Calculates duration between two dates.
     *
     * @param \DateTime $startDate The starting date of the duration.
     * @param \DateTime $endDate The ending date of the duration.
     * @return int The calculated duration in the units defined by the implementation.
     */
    public function calculate(\DateTime $startDate, \DateTime $endDate): int;
}
