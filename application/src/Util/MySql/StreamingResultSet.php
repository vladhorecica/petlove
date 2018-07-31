<?php

namespace Util\MySql;

class StreamingResultSet extends ResultSet
{
    /** @var bool */
    private $fetched = false;
    /** @var int */
    private $key;
    /** @var mixed[]|null */
    private $current;

    /**
     * @param \mysqli_stmt $stmt
     */
    public function __construct(\mysqli_stmt $stmt)
    {
        parent::__construct($stmt);
    }

    /**
     * @return $this
     */
    private function fetch()
    {
        if (!$this->fetched) {
            $result = $this->stmt->fetch();
            $this->fetched = true;
            if ($result === true) {
                ++$this->key;
                $this->current = self::copyArray($this->bindings);

                return $this;
            } elseif ($result === null) {
                ++$this->key;
                $this->current = null;

                return $this;
            }
            $this->key = null;
            $this->current = null;
            throw new Error($this->stmt->error, $this->stmt->errno);
        }
    }

    /**
     * @return mixed[]
     */
    public function current()
    {
        $this->fetch();

        return $this->current;
    }

    public function next()
    {
        $this->fetch();
        $this->fetched = false;
    }

    /**
     * @return int
     */
    public function key()
    {
        $this->fetch();

        return $this->key;
    }

    public function rewind()
    {
        $this->seek(0);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $this->fetch();

        return (bool) $this->current;
    }

    /**
     * @param int $offset
     */
    public function seek($offset)
    {
        $this->stmt->data_seek($offset);
        $this->key = $offset - 1;
        $this->fetched = false;
    }
}
