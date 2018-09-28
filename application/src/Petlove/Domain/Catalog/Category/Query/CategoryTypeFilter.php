<?php

namespace Petlove\Domain\Catalog\Category\Query;

use Petlove\Domain\Catalog\Category\Value\CategoryType;
use Petlove\Domain\Common\Query\ValueFilter;

class CategoryTypeFilter extends ValueFilter
{
    const VALUE_TYPE = CategoryType::class;
}
