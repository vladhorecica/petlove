<?php

namespace Util\MySql\Util;

use Util\Value\Page;

class DeleteQueryBuilder
{
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
    /** @var Page */
    private $limit = [];
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
     * @param string $sql
     * @param array  $parameters
     *
     * @return $this
     */
    public function join($sql, ...$parameters)
    {
        $this->join[] = $sql;
        $this->joinParameters = array_merge($this->joinParameters, $parameters);

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
     * @param Page|null $page
     *
     * @return $this
     */
    public function limit(Page $page = null)
    {
        $this->limit = $page;
        $this->limitParameters = [$page->getOffset(), $page->getSize()];

        return $this;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return 'DELETE FROM '.$this->from
        .($this->join ? ' '.implode(' ', $this->join) : '')
        .($this->where ? ' WHERE ('.implode(') AND (', $this->where).')' : '')
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
