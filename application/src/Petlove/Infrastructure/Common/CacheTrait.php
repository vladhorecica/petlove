<?php

namespace Petlove\Infrastructure\Common;

trait CacheTrait
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param mixed $cache
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }
}
