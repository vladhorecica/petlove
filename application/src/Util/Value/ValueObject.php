<?php

namespace Util\Value;

interface ValueObject
{
    /**
     * @param ValueObject|null $other
     *
     * @return bool
     */
    public function equals(ValueObject $other = null);
}
