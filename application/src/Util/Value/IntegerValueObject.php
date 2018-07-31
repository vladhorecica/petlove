<?php

namespace Util\Value;

/**
 * @SuppressWarnings(PHPMD)
 */
class IntegerValueObject extends ScalarValueObject
{
    /**
     * @param int $value
     */
    public function __construct($value)
    {
        if (!is_integer($value)) {
            throw new \InvalidArgumentException();
        }

        parent::__construct($value);
    }
}
