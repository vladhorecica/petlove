<?php

namespace Petlove\Domain\Catalog\Category\Query;

use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Common\Query\ValueFilter;

class CategoryIdFilter extends ValueFilter
{
    const VALUE_TYPE = CategoryId::class;
}
