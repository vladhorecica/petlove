<?php

namespace Util\Value;

abstract class DirectionalSorting
{
    /** @var SortingDirection */
    private $direction;

    /**
     * @param SortingDirection $direction
     */
    public function __construct(SortingDirection $direction = null)
    {
        $this->direction = $direction ?: SortingDirection::asc();
    }

    /**
     * @return SortingDirection
     */
    public function getDirection()
    {
        return $this->direction;
    }
}
