<?php

namespace Util\MySql;

class Error extends \RuntimeException
{
    /** @var int */
    private $mysqlErrno;

    /**
     * @param string $message
     * @param int    $mysqlErrno
     */
    public function __construct($message, $mysqlErrno)
    {
        parent::__construct($message);
        $this->mysqlErrno = $mysqlErrno;
    }

    /**
     * @return int
     */
    public function getMysqlErrno()
    {
        return $this->mysqlErrno;
    }
}
