<?php

namespace Petlove\Infrastructure\Catalog\Category;

use Petlove\Domain\Catalog\Category\Category;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;
use Petlove\Domain\Catalog\Category\Value\CategoryType;

/**
 * Class CategoryMysqlToDomainMapper
 * @package Petlove\Infrastructure\Catalog\Category
 */
class CategoryMysqlToDomainMapper
{
    public function map(array $data): Category
    {
        return new Category(
            new CategoryId($data['c.id']),
            new CategoryName($data['c.name']),
            new CategoryType($data['c.type']),
            ($data['c.parent_id']) ? new CategoryId($data['c.parent_id']) : null
        );
    }
}
