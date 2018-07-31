<?php

namespace Petlove\Domain\Common\Query;

use Util\Util\Gen;
use Util\Value\Page;
use Countable;

class Result implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /** @var Page|null */
    private $page;
    /** @var integer|null */
    private $total;
    /** @var array|\Iterator */
    private $items;

    /**
     * @param Page|null $page
     * @param int|null $total
     * @param array|\Iterator $items
     */
    public function __construct(Page $page = null, $total, $items)
    {
        $this->page = $page;
        $this->total = $total;
        $this->items = $items;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        if (is_array($this->items)) {
            return new \ArrayIterator($this->items);
        } else {
            return $this->items;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        if (!is_array($this->items) && !($this->items instanceof \ArrayAccess)) {
            $this->items = iterator_to_array($this->items);
        }
        return isset($this->items[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if (!is_array($this->items) && !($this->items instanceof \ArrayAccess)) {
            $this->items = iterator_to_array($this->items);
        }
        return $this->items[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        throw new \LogicException("Result is read-only");
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        throw new \LogicException("Result is read-only");
    }

    /**
     * @return integer
     */
    public function count()
    {
        if (!is_array($this->items) && !($this->items instanceof Countable)) {
            $this->items = iterator_to_array($this->items);
        }
        return count($this->items);
    }

    /**
     * @param callable $fn
     *
     * @return \Generator
     */
    public function map(callable $fn)
    {
        return Gen::map($this, $fn);
    }
}
