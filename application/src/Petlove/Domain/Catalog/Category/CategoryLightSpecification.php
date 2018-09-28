<?php

namespace Petlove\Domain\Catalog\Category;

use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;

interface CategoryLightSpecification
{
    /**
     * @param CategoryName $name
     * @return bool
     */
    public function existsByName(CategoryName $name);

    /**
     * @param CategoryId $id
     * @return bool
     */
    public function exists(CategoryId $id);
}
