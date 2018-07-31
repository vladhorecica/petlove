<?php

namespace Util\MySql\Util;

use Util\Value\Page;
use Util\Exception\ImplementationError;

class SelectQueryBuilder
{
    /** @var string */
    private $select = '*';
    /** @var string */
    private $option = '';
    /** @var string */
    private $from;
    /** @var string[] */
    private $join = [];
    /** @var mixed[] */
    private $joinParameters = [];
    /** @var string[] */
    private $where = [];
    /** @var mixed[] */
    private $whereParameters = [];
    /** @var string[] */
    private $groupBy = [];
    /** @var string[] */
    private $orderBy = [];
    /** @var Page */
    private $limit;
    /** @var int[] */
    private $limitParameters = [];

    /**
     * @param string $from
     */
    public function __construct($from)
    {
        $this->from = $from;
    }

    /**
     * @param string $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param $select
     *
     * @return self
     */
    public function select($select)
    {
        $this->select = $select;

        return $this;
    }

    /**
     * @param string $option
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

    /**
     * @return $this
     */
    public function selectCount()
    {
        $this->select = 'COUNT(*)';

        return $this;
    }

    /**
     * @param string $sql
     * @param array  $parameters
     *
     * @return $this
     */
    public function join($sql, ...$parameters)
    {
        if (!in_array($sql, $this->join, true)) {
            $this->join[] = $sql;
            $this->joinParameters = array_merge($this->joinParameters, $parameters);
        }

        return $this;
    }

    /**
     * @param string $sql
     * @param array  $parameters
     *
     * @return $this
     */
    public function andWhere($sql, ...$parameters)
    {
        if ($sql instanceof Fragment) {
            assert(!$parameters);
            $this->where[] = $sql->getSql();
            $this->whereParameters = array_merge($this->whereParameters, $sql->getParameters());

            return $this;
        }
        $this->where[] = $sql;
        $this->whereParameters = array_merge($this->whereParameters, $parameters);

        return $this;
    }

    /**
     * @param string $sql
     *
     * @return $this
     */
    public function groupBy($sql)
    {
        $this->groupBy[] = $sql;

        return $this;
    }

    /**
     * @param string $sql
     *
     * @return $this
     */
    public function orderBy($sql)
    {
        if ($sql instanceof Fragment) {
            $this->orderBy[] = $sql->getSql();
            if ($sql->getParameters()) {
                throw new ImplementationError();
            }

            return $this;
        }

        $this->orderBy[] = $sql;

        return $this;
    }

    /**
     * @param Page|null $page
     *
     * @return $this
     */
    public function limit(Page $page = null)
    {
        $this->limit = $page;
        $this->limitParameters = $page ? [$page->getOffset(), $page->getSize()] : [];

        return $this;
    }

    /**
     * @return Page|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return 'SELECT '.$this->option.' '.$this->select
            .' FROM '.$this->from
            .($this->join ? ' '.implode(' ', $this->join) : '')
            .($this->where ? ' WHERE ('.implode(') AND (', $this->where).')' : '')
            .($this->groupBy ? ' GROUP BY '.implode(', ', $this->groupBy) : '')
            .($this->orderBy ? ' ORDER BY '.implode(', ', $this->orderBy) : '')
            .($this->limit ? ' LIMIT ?, ?' : '');
    }

    /**
     * @return mixed[]
     */
    public function getParameters()
    {
        return array_merge($this->joinParameters, $this->whereParameters, $this->limitParameters);
    }
}
