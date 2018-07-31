<?php

namespace Util\Value;

/**
 * @SuppressWarnings(PHPMD)
 */
abstract class Enum implements \JsonSerializable, ValueObject
{
    /** string[] */
    const VALUES = [];

    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     */
    final public function __construct($value)
    {
        if (!in_array($value, static::VALUES, true)) {
            throw new \InvalidArgumentException($value);
        }
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return str_replace('_', ' ', $this->value);
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
    final public function equals(ValueObject $other = null)
    {
        /* @var Enum $other */
        return get_class($this) === get_class($other) && $this->value === $other->value;
    }

    /**
     * @param string $name
     *
     * @return static|mixed
     *
     * @deprecated use constructor instead
     */
    final public static function get($name)
    {
        $constant = static::class.'::'.strtoupper($name);
        if (!defined($constant)) {
            throw new \InvalidArgumentException();
        }

        return new static(constant($constant));
    }

    /**
     * @return static[]
     */
    final public static function getAll()
    {
        $all = [];
        foreach (static::VALUES as $value) {
            $all[] = new static($value);
        }

        return $all;
    }

    /**
     * @param string $methodName
     * @param array  $arguments
     *
     * @return static
     */
    public static function __callStatic($methodName, array $arguments)
    {
        return new static($methodName);
    }
}
