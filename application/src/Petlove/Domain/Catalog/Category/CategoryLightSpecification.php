<?php

namespace Petlove\Domain\Catalog\Category;

use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;

/**
 * Interface CategoryLightSpecification
 * @package Petlove\Domain\Catalog\Category
 */
interface CategoryLightSpecification
{
    public function existsByName(CategoryName $name): bool;

    public function exists(CategoryId $id): bool;
}
