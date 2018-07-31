<?php

namespace Util\Value;

class Page
{
    /** @var int */
    private $offset;
    /** @var int */
    private $size;

    /**
     * @param int $offset
     * @param int $size
     */
    public function __construct($offset = 0, $size = 10)
    {
        if (!is_integer($offset) || $offset < 0) {
            throw new \InvalidArgumentException();
        }
        if (!is_integer($size) || $size <= 0) {
            throw new \InvalidArgumentException();
        }

        $this->offset = $offset;
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
}
