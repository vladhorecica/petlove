<?php

namespace Petlove\Domain\Catalog\Category\Value;

use Util\Value\Enum;

/**
 * @method static CategoryType invertebrates()
 * @method static CategoryType fish()
 * @method static CategoryType amphibians()
 * @method static CategoryType reptiles()
 * @method static CategoryType birds()
 * @method static CategoryType mammals()
 */
class CategoryType extends Enum
{
    const VALUES = ['invertebrates', 'fish', 'amphibians', 'reptiles', 'birds', 'mammals'];
}
