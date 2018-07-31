<?php

namespace Util\Value;

class FloatValueObject extends ScalarValueObject
{
    /**
     * @param float $value
     */
    public function __construct($value)
    {
        if (!(is_float($value) || is_integer($value))) {
            throw new \InvalidArgumentException();
        }

        parent::__construct($value);
    }

    /**
     * @param ValueObject|null $other
     *
     * @return bool
     */
    public function equals(ValueObject $other = null)
    {
        return $other !== null && $other instanceof static && (abs($this->getValue() - $other->getValue()) < 0.00001);
    }
}
