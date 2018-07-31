<?php

namespace Util\Value;

abstract class ScalarValueObject implements ValueObject, \JsonSerializable
{
    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * @param ValueObject|null $other
     *
     * @return bool
     */
    public function equals(ValueObject $other = null)
    {
        return $other !== null && $other instanceof self && $this->value === $other->value;
    }
}
