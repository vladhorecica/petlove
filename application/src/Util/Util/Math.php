<?php

namespace Util\Util;

abstract class Math
{
    /**
     * @param int $first
     * @param int $second
     *
     * @return int
     */
    public static function intdiv($first, $second)
    {
        if ($second === 0) {
            throw new \InvalidArgumentException();
        }

        return ($first - $first % $second) / $second;
    }
}
