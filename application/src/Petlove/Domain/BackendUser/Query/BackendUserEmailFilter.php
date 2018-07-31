<?php

namespace Petlove\Domain\BackendUser\Query;

use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\Common\Query\ValueFilter;

class BackendUserEmailFilter extends ValueFilter
{
    const VALUE_TYPE = BackendUserEmail::class;
}
