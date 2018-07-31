<?php

namespace Petlove\ApiBundle\DataProcessor;

use Util\Data\DataHelper;
use Util\Data\DataProcessingError;
use Util\Data\DataProcessor;
use Util\Value\Page;

class PageProcessor implements DataProcessor
{
    /** @var int */
    private $defaultOffset;
    /** @var int|null */
    private $maxOffset;
    /** @var int */
    private $defaultSize;
    /** @var int|null */
    private $maxSize;

    /**
     * @param int      $defaultOffset
     * @param int|null $maxOffset
     * @param int      $defaultSize
     * @param int|null $maxSize
     */
    public function __construct($defaultOffset, $maxOffset, $defaultSize, $maxSize)
    {
        $this->defaultOffset = $defaultOffset;
        $this->maxOffset = $maxOffset;
        $this->defaultSize = $defaultSize;
        $this->maxSize = $maxSize;
    }

    /**
     * @param mixed $in
     *
     * @return Page
     */
    public function __invoke($in)
    {
        $in = new DataHelper($in);

        $page = new Page(
            $in->maybe()->access('offset')->defaultTo($this->defaultOffset)->getPositiveInteger(),
            $in->maybe()->access('size')->defaultTo($this->defaultSize)->getPositiveInteger()
        );

        if ($this->maxOffset !== null && $page->getOffset() > $this->maxOffset) {
            throw new DataProcessingError('Offset is too far');
        }
        if ($this->maxSize !== null && $page->getSize() > $this->maxSize) {
            throw new DataProcessingError('Size is too big');
        }

        return $page;
    }
}
