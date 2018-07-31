<?php

namespace Util\MySql;

abstract class ResultSet implements \SeekableIterator
{
    /** @var \mysqli_stmt */
    protected $stmt;
    /** @var mixed[] */
    protected $bindings;

    /**
     * @param \mysqli_stmt $stmt
     */
    public function __construct(\mysqli_stmt $stmt)
    {
        $this->stmt = $stmt;

        $this->bindings = [];
        $bindResultArgs = [];
        $meta = $stmt->result_metadata();
        while (($field = $meta->fetch_field())) {
            if ($field->table !== '') {
                $bindResultArgs[] = &$this->bindings["{$field->table}.{$field->name}"];
            } else {
                $bindResultArgs[] = &$this->bindings[$field->name];
            }
        }
        $stmt->bind_result(...$bindResultArgs);
    }

    /**
     * @return mixed[]|null
     */
    public function fetchRow()
    {
        foreach ($this as $row) {
            return $row;
        }

        return;
    }

    /**
     * @return mixed|null
     */
    public function fetchValue()
    {
        foreach ($this as $row) {
            return $row[array_keys($row)[0]];
        }

        return;
    }

    /**
     * @return mixed[][]
     */
    public function toArray()
    {
        return iterator_to_array($this);
    }

    /**
     * Take a shallow copy of an array, breaking references.
     *
     * @param array $source
     *
     * @return array
     */
    public static function copyArray(array $source)
    {
        $copied = [];
        foreach ($source as $k => $v) {
            $copied[$k] = $v;
        }

        return $copied;
    }
}
