<?php

namespace Petlove\Domain\Common\Query;

class AndFilter
{
    /** @var mixed[] */
    private $filters;

    /**
     * @param mixed[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return mixed[]
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
