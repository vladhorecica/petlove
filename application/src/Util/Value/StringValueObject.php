<?php

namespace Util\Value;

/**
 * @SuppressWarnings(PHPMD)
 */
abstract class StringValueObject extends ScalarValueObject
{
    /**
     * @param string $value
     */
    public function __construct($value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException();
        }

        parent::__construct($value);
    }
}
