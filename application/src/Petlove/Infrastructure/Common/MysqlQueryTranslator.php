<?php

namespace Petlove\Infrastructure\Common;

use Util\MySql\Util\Fragment;
use Petlove\Domain\Common\Query\AndFilter;
use Petlove\Domain\Common\Query\NotFilter;
use Petlove\Domain\Common\Query\OrFilter;
use Petlove\Infrastructure\Exception\ImplementationError;

abstract class MysqlQueryTranslator
{
    /**
     * @param mixed $filter
     *
     * @return Fragment
     */
    public function translateFilter($filter)
    {
        if ($filter === null) {
            return new Fragment('TRUE');
        } elseif ($filter instanceof AndFilter) {
            if (!$filter->getFilters()) {
                return new Fragment('TRUE');
            }

            $sql = [];
            $parameters = [];
            foreach ($filter->getFilters() as $clause) {
                $clauseFragment = $this->translateFilter($clause);
                $sql[] = "({$clauseFragment->getSql()})";
                $parameters = array_merge($parameters, $clauseFragment->getParameters());
            }

            return new Fragment(implode('AND', $sql), ...$parameters);
        } elseif ($filter instanceof OrFilter) {
            if (!$filter->getFilters()) {
                return new Fragment('FALSE');
            }

            $sql = [];
            $parameters = [];
            foreach ($filter->getFilters() as $clause) {
                $clauseFragment = $this->translateFilter($clause);
                $sql[] = "({$clauseFragment->getSql()})";
                $parameters = array_merge($parameters, $clauseFragment->getParameters());
            }

            return new Fragment(implode('OR', $sql), ...$parameters);
        } elseif ($filter instanceof NotFilter) {
            $fragment = $this->translateFilter($filter->getFilter());

            return new Fragment("NOT ({$fragment->getSql()})", ...$fragment->getParameters());
        } else {
            throw new ImplementationError(get_class($filter));
        }
    }

    /**
     * @param mixed $sorting
     *
     * @return Fragment
     */
    public function translateSorting($sorting)
    {
        if ($sorting === null) {
            return new Fragment('TRUE');
        } else {
            throw new ImplementationError(get_class($sorting));
        }
    }
}
