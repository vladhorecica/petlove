<?php

namespace Util\Util;

class Gen
{
    /**
     * @param \Traversable $iterable
     * @param callable     $callable
     *
     * @return \Generator
     */
    public static function map($iterable, $callable)
    {
        foreach ($iterable as $item) {
            yield $callable($item);
        }
    }
}
