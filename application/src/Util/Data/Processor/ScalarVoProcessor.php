<?php

namespace Util\Data\Processor;

use Util\Data\DataProcessingError;

class ScalarVoProcessor
{
    /** @var string */
    private $class;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param mixed $in
     *
     * @return object
     */
    public function __invoke($in)
    {
        $class = $this->class;
        try {
            return new $class($in);
        } catch (\InvalidArgumentException $e) {
            throw new DataProcessingError($e->getMessage() ?: 'invalid value');
        }
    }
}
