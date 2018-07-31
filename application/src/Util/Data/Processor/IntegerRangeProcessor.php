<?php

namespace Util\Data\Processor;

use Util\Data\DataHelper;
use Util\Data\DataProcessor;
use Util\Value\IntegerRange;

class IntegerRangeProcessor implements DataProcessor
{
    /**
     * @param mixed $in
     *
     * @return IntegerRange
     */
    public function __invoke($in)
    {
        $in = new DataHelper($in);

        return new IntegerRange(
            $in->maybe()->access('from')->maybe()->getPositiveInteger(),
            $in->maybe()->access('to')->maybe()->getPositiveInteger()
        );
    }
}
