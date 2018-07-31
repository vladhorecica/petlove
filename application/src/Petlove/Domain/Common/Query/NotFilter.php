<?php

namespace Petlove\Domain\Common\Query;

class NotFilter
{
    /** @var mixed */
    private $filter;

    /**
     * @param mixed $filter
     */
    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
