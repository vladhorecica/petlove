<?php

namespace Util\Util;


class Date
{
    /**
     * @param \DateTimeImmutable $timestamp
     *
     * @return string|null
     */
    public static function serializeTimestamp(\DateTimeImmutable $timestamp = null)
    {
        if ($timestamp) {
            return $timestamp->format(\DateTime::ISO8601);
        }

        return;
    }
}