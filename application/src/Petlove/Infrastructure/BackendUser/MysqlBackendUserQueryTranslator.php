<?php

namespace Petlove\Infrastructure\BackendUser;

use Util\MySql\Util\Fragment;
use Petlove\Domain\BackendUser\Query\BackendUserEmailFilter;
use Petlove\Infrastructure\Common\MysqlQueryTranslator;

class MysqlBackendUserQueryTranslator extends MysqlQueryTranslator
{
    /**
     * @param mixed $filter
     *
     * @return Fragment
     */
    public function translateFilter($filter)
    {
        if ($filter instanceof BackendUserEmailFilter) {
            return new Fragment('bu.email = ?', $filter->getValue());
        }

        return parent::translateFilter($filter);
    }
}
