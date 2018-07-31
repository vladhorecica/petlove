<?php

namespace Util\Util;

use ArrayIterator;

/**
 * @SuppressWarnings(PHPMD)
 */
class ArrayCollection implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    private $elements;

    /**
     * Initializes a new ArrayCollection.
     *
     * @param array $elements
     */
    public function __construct(array $elements = array())
    {
        $this->elements = $elements;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $key = (string) $key;
        if (!isset($this->elements[$key])) {
            return;
        }

        $removed = $this->elements[$key];
        unset($this->elements[$key]);

        return $removed;
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->elements, true);

        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);

        return true;
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (!isset($offset)) {
            return $this->add($value);
        }

        $this->set($offset, $value);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        return isset($this->elements[(string) $key]);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return isset($this->elements[(string) $key]) ? $this->elements[(string) $key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return array_values($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->elements[(string) $key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        $this->elements[] = $value;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return empty($this->elements);
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->elements = array();
    }
}
