<?php

namespace Petlove\Infrastructure\Common\Value;

use Util\Value\Enum;

/**
 * @method static DatabaseType tenant()
 * @method static DatabaseType master()
 */
class DatabaseType extends Enum
{
    const VALUES = ['tenant', 'master'];
}
