<?php

namespace Util\MySql;

class BufferedResultSet extends ResultSet implements \Countable
{
    /** @var int|null */
    private $key;
    /** @var mixed[]|null */
    private $current;

    /**
     * @param \mysqli_stmt $stmt
     */
    public function __construct(\mysqli_stmt $stmt)
    {
        // see https://bugs.php.net/bug.php?id=51386
        $stmt->store_result();
        parent::__construct($stmt);
        $this->rewind();
    }

    /**
     * @return $this
     */
    private function fetch()
    {
        $result = $this->stmt->fetch();
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

    /**
     * @return mixed[]
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        $this->fetch();
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
        return (bool) $this->current;
    }

    /**
     * @param int $offset
     */
    public function seek($offset)
    {
        $this->stmt->data_seek($offset);
        $this->key = $offset - 1;
        $this->fetch();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->stmt->num_rows;
    }
}
