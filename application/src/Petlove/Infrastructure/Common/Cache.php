<?php

namespace Petlove\Infrastructure\Common;

use Petlove\Infrastructure\Exception\ImplementationError;
use Util\Util\ArrayCollection;

class Cache extends ArrayCollection
{
    /** @var int|null */
    private $max;

    /**
     * @param int|null $max
     */
    public function __construct($max = 10)
    {
        $this->max = $max;
        parent::__construct();
    }

    /**
     * @param mixed    $key
     * @param callable $load
     *
     * @return mixed
     */
    public function get($key, callable $load = null)
    {
        $entity = $this->getEntity($key, $load);
        $this->set($key, $entity);

        return $entity;
    }

    /**
     * @param mixed         $key
     * @param callable|null $load
     *
     * @return mixed|null
     */
    private function getEntity($key, callable $load = null)
    {
        if ($this->containsKey($key)) {
            return parent::get($key);
        }

        if (!$load) {
            throw new ImplementationError('Cache miss without a loader');
        }

        return $load();
    }
}
