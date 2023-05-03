<?php

declare(strict_types=1);

namespace ConstructionStages;

class DateTime extends \DateTime
{
    /**
     * Create a `DateTime` object from an ISO-formatted string.
     *
     * @param string $date The date string in ISO format (e.g. "2023-05-03T16:30:00Z").
     *
     * @return \DateTime The `DateTime` object representing the given date and time.
     */
    public static function createFromIsoFormat(string $date): \DateTime
    {
        $format = 'Y-m-d\TH:i:s\Z';

        return \DateTime::createFromFormat($format, $date);
    }
}
