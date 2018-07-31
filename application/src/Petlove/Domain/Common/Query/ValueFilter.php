<?php

namespace Petlove\Domain\Common\Query;

abstract class ValueFilter
{
    const VALUE_TYPE = null;

    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $type = static::VALUE_TYPE;
        if ($type && gettype($value) !== $type && !($value instanceof $type)) {
            throw new \InvalidArgumentException();
        }

        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
