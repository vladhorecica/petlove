<?php

namespace Util\Util;

class Calendar
{
    /**
     * @param \DateTimeImmutable $date1
     * @param \DateTimeImmutable $date2
     *
     * @return int
     */
    public static function diffInMonths(\DateTimeImmutable $date1, \DateTimeImmutable $date2)
    {
        $diff = $date1->diff($date2);

        return $diff->y * 12 + $diff->m;
    }

    /**
     * @param \DateTimeImmutable $date1
     * @param \DateTimeImmutable $date2
     *
     * @return int
     */
    public static function diffInDays(\DateTimeImmutable $date1, \DateTimeImmutable $date2)
    {
        return $date1->diff($date2)->days;
    }
}
