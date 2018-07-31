<?php

namespace Petlove\Infrastructure\Common\Helper;

class DateDbMapper
{
    /**
     * @param \DateTimeImmutable|null $timestamp
     *
     * @return int|null
     */
    public static function mapDateTimeToDb(\DateTimeImmutable $timestamp = null)
    {
        if ($timestamp === null) {
            return;
        }

        return $timestamp->getTimestamp();
    }

    /**
     * @param int $unixTimestamp
     *
     * @return bool|\DateTimeImmutable|null
     * @throws \Exception
     */
    public static function mapTimestampToDateTime($unixTimestamp)
    {
        if ($unixTimestamp === null) {
            return;
        }

        return (new \DateTimeImmutable())->setTimestamp($unixTimestamp);
    }
}
