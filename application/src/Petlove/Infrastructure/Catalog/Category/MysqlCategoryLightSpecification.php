<?php

namespace Petlove\Infrastructure\Catalog\Category;

use Petlove\Domain\Catalog\Category\CategoryLightSpecification;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;
use Util\MySql\Connection;

/**
 * Class MysqlCategoryLightSpecification
 * @package Petlove\Infrastructure\BackendUser
 */
class MysqlCategoryLightSpecification implements CategoryLightSpecification
{
    /**
     * @var Connection
     */
    private $mysql;

    /**
     * MysqlCategoryLightSpecification constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->mysql = $db;
    }

    public function existsByName(CategoryName $name): bool
    {
        return (bool) $this->mysql->bufferedQuery('
          SELECT c.id FROM catalog_categories c WHERE c.name = ? LIMIT 1
         ', $name)->fetchValue();
    }

    public function exists(CategoryId $id): bool
    {
        return (bool) $this->mysql->bufferedQuery('
          SELECT c.id FROM catalog_categories c WHERE c.id = ? LIMIT 1
         ', $id)->fetchValue();
    }
}
