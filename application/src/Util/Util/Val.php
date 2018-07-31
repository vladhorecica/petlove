<?php

namespace Util\Util;

use Util\Value\ValueObject;

abstract class Val
{
    /**
     * @param ValueObject|null $first
     * @param ValueObject|null $second
     *
     * @return bool
     */
    public static function equals(ValueObject $first = null, ValueObject $second = null)
    {
        if ($first === null) {
            return $second === null;
        }

        return $first->equals($second);
    }

    /**
     * @param ValueObject[]|\Generator $haystack
     * @param ValueObject|null         $needle
     *
     * @return bool
     */
    public static function in($haystack, ValueObject $needle = null)
    {
        foreach ($haystack as $item) {
            if (self::equals($needle, $item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ValueObject[] $haystack
     * @param ValueObject   $needle
     *
     * @return ValueObject[]
     */
    public static function without(array $haystack, ValueObject $needle)
    {
        return array_filter($haystack, function (ValueObject $item) use ($needle) {
            return !$item->equals($needle);
        });
    }

    /**
     * @param ValueObject[] $collection
     *
     * @return ValueObject[]
     */
    public static function unique(array $collection)
    {
        $unique = [];
        foreach ($collection as $item) {
            if (!self::in($unique, $item)) {
                $unique[] = $item;
            }
        }

        return $unique;
    }

    /**
     * @param ValueObject[] $iterator1
     * @param ValueObject[] $iterator2
     *
     * @return bool
     */
    public static function intersects($iterator1, $iterator2)
    {
        if (!(is_array($iterator1) || $iterator1 instanceof \Traversable)) {
            throw new \InvalidArgumentException();
        }
        if (!(is_array($iterator2) || $iterator2 instanceof \Traversable)) {
            throw new \InvalidArgumentException();
        }
        foreach ($iterator1 as $item) {
            foreach ($iterator2 as $subItem) {
                if ($subItem->equals($item)) {
                    return true;
                }
            }
        }

        return false;
    }
}
