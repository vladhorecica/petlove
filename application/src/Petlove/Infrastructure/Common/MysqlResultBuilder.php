<?php

namespace Petlove\Infrastructure\Common;

use Util\MySql\Connection;
use Util\MySql\Util\SelectQueryBuilder;
use Util\Util\Gen;
use Petlove\Domain\Common\Query\Result;

trait MysqlResultBuilder
{
    /**
     * @param Connection $connection
     * @param SelectQueryBuilder $query
     * @param callable $mapResult
     *
     * @return Result|mixed[][]
     */
    public function createResult(Connection $connection, SelectQueryBuilder $query, callable $mapResult)
    {
        $items = $this->getItems($connection, $query);
        $total = $this->getTotal($connection, $query, $items);

        return new Result($query->getLimit(), $total, Gen::map($items, $mapResult));
    }

    /**
     * @param Connection $connection
     * @param SelectQueryBuilder $query
     * @param callable $mapResult
     *
     * @return Result
     */
    public function createResultFromGenerator(Connection $connection, SelectQueryBuilder $query, callable $mapResult)
    {
        $items = $this->getItems($connection, $query);
        $total = $this->getTotal($connection, $query, $items);

        return new Result($query->getLimit(), $total, $mapResult($items));
    }

    /**
     * @param Connection $connection
     * @param SelectQueryBuilder $query
     * @param SelectQueryBuilder $filterQuery
     * @param callable $mapResult
     *
     * @return Result
     */
    public function createResultWithFilterFromGenerator(Connection $connection,
        SelectQueryBuilder $query,
        SelectQueryBuilder $filterQuery,
        callable $mapResult)
    {
        $filteredItems = $this->getItems($connection, $filterQuery);
        $total = $this->getTotal($connection, $filterQuery, $filteredItems);
        $items = $this->getItems($connection, $query);

        return new Result($filterQuery->getLimit(), $total, $mapResult($items));
    }

    /**
     * @param Connection $connection
     * @param SelectQueryBuilder $query
     *
     * @return \Util\MySql\BufferedResultSet|\mixed[][]
     */
    private function getItems(Connection $connection, SelectQueryBuilder $query)
    {
        if ($query->getLimit()) {
            $query->setOption("SQL_CALC_FOUND_ROWS");
        }

        return $connection->bufferedQuery($query);
    }

    /**
     * @param Connection $connection
     * @param SelectQueryBuilder $query
     * @param \Countable|null $items
     *
     * @return int|mixed|null
     */
    private function getTotal(Connection $connection, SelectQueryBuilder $query, \Countable $items = null)
    {
        if ($query->getLimit()) {
            return $connection->bufferedQuery("SELECT FOUND_ROWS()")->fetchValue();
        }
        if ($items instanceof \Countable) {
            return count($items);
        }

        return null;
    }
}
