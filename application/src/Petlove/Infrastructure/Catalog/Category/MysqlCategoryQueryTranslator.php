<?php

namespace Petlove\Infrastructure\Catalog\Category;

use Petlove\Domain\Catalog\Category\Query\CategoryIdFilter;
use Petlove\Domain\Catalog\Category\Query\CategoryTypeFilter;
use Petlove\Domain\Catalog\Category\Query\ParentCategoryIdFilter;
use Util\MySql\Util\Fragment;
use Petlove\Infrastructure\Common\MysqlQueryTranslator;

class MysqlCategoryQueryTranslator extends MysqlQueryTranslator
{
    /**
     * @param mixed $filter
     *
     * @return Fragment
     */
    public function translateFilter($filter)
    {
        if ($filter instanceof CategoryTypeFilter) {
            return new Fragment('c.type = ?', $filter->getValue());
        } else if ($filter instanceof CategoryIdFilter) {
            return new Fragment('c.id = ?', $filter->getValue());
        } else if ($filter instanceof ParentCategoryIdFilter) {
            return new Fragment('c.parent_id = ?', $filter->getValue());
        }

        return parent::translateFilter($filter);
    }
}
