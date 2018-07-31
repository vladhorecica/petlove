<?php

namespace Petlove\Domain\BackendUser\Value;

use Util\Value\Enum;

/**
 * @method static BackendUserType admin()
 */
class BackendUserType extends Enum
{
    const VALUES = ['admin'];
}
