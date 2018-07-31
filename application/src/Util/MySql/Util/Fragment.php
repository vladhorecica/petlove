<?php

namespace Util\MySql\Util;

class Fragment
{
    /** @var string */
    private $sql;
    /** @var mixed[] */
    private $parameters;

    /**
     * @param string $sql
     * @param array  $parameters
     */
    public function __construct($sql, ...$parameters)
    {
        $this->sql = $sql;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @return mixed[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
