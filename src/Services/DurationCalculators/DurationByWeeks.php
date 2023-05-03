<?php

declare(strict_types=1);

namespace ConstructionStages\Services\DurationCalculators;

class DurationByWeeks implements Calculator
{
    /** @inheritDoc */
    public function calculate(\DateTime $startDate, \DateTime $endDate): int
    {
        $diff = $endDate->diff($startDate);

        return intval($diff->days / 7 * 24);
    }
}
