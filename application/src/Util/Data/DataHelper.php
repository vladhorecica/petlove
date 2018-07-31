<?php

namespace Util\Data;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class DataHelper
{
    /** @var mixed */
    private $value;
    /** @var bool */
    private $maybe = false;
    /** @var string|null */
    private $path = [];

    /**
     * @param mixed    $value
     * @param string[] $path
     */
    public function __construct($value, $path = [])
    {
        $this->value = $value;
        $this->path = $path;
    }

    /**
     * @return DataHelper
     */
    public function maybe()
    {
        $maybeHelper = clone $this;
        $maybeHelper->maybe = true;

        return $maybeHelper;
    }

    /**
     * @param callable $processor
     *
     * @return DataHelper
     */
    public function process(callable $processor)
    {
        if ($this->maybe && $this->value === null) {
            return $this;
        }

        try {
            return new self($processor($this->value));
        } catch (DataProcessingError $e) {
            throw new DataProcessingError($e->getErrorMessage(), array_merge($this->path, $e->getPath()));
        }
    }

    /**
     * @param string $message
     *
     * @return DataProcessingError
     */
    public function createError($message)
    {
        return new DataProcessingError($message, $this->path);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        if ($this->maybe && !is_array($this->value)) {
            return false;
        }

        if (!is_array($this->value)) {
            throw new DataProcessingError('value is not an array', $this->path);
        }

        return array_key_exists($key, $this->value);
    }

    /**
     * @param string $key
     *
     * @return DataHelper
     */
    public function access($key)
    {
        if ($this->maybe) {
            if (is_null($this->value)
                || (is_array($this->value) && !array_key_exists($key, $this->value))
            ) {
                return (new self(null, array_merge($this->path, [$key])))->maybe();
            }
        }

        if (!is_array($this->value) || !array_key_exists($key, $this->value)) {
            throw new DataProcessingError("missing key `$key`", $this->path);
        }

        return new self($this->value[$key], array_merge($this->path, [$key]));
    }

    /**
     * @param callable $processor
     *
     * @return DataHelper
     */
    public function map(callable $processor)
    {
        if ($this->maybe && $this->value === null) {
            return $this;
        }

        if (!is_array($this->value)) {
            throw new DataProcessingError('value is not an array', $this->path);
        }

        return new self(array_map($processor, $this->value));
    }

    /**
     * @param mixed $default
     *
     * @return $this
     */
    public function defaultTo($default)
    {
        if ($this->value === null) {
            $this->value = $default;
        }

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function get()
    {
        if ($this->maybe && $this->value === null) {
            return;
        }

        if ($this->value === null) {
            throw new DataProcessingError('value is null', $this->path);
        }

        return $this->value;
    }

    /**
     * @return bool|null
     */
    public function getBoolean()
    {
        if ($this->maybe && $this->value === null) {
            return;
        }

        if (!is_bool($this->value)) {
            throw new DataProcessingError('value is not a boolean', $this->path);
        }

        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getString()
    {
        if ($this->maybe && $this->value === null) {
            return;
        }

        if (!is_string($this->value)) {
            throw new DataProcessingError('value is not a string', $this->path);
        }

        return $this->value;
    }

    /**
     * @return int|null
     */
    public function getInteger()
    {
        if ($this->maybe && $this->value === null) {
            return;
        }

        if (is_string($this->value) && ((string) (int) $this->value) === $this->value) {
            return (int) $this->value;
        }

        if (!is_int($this->value)) {
            throw new DataProcessingError('value is not an integer', $this->path);
        }

        return $this->value;
    }

    /**
     * @return int|null
     */
    public function getPositiveInteger()
    {
        $value = $this->getInteger();

        if ($value !== null && $value < 0) {
            throw new DataProcessingError('value is not a positive integer', $this->path);
        }

        return $value;
    }

    /**
     * @return float|null
     */
    public function getFloat()
    {
        if ($this->maybe && $this->value === null) {
            return;
        }

        if (!(is_float($this->value) || is_int($this->value))) {
            throw new DataProcessingError('value is not numeric', $this->path);
        }

        return (float) $this->value;
    }
}
