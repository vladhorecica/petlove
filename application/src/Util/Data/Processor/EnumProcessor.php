<?php

namespace Util\Data\Processor;

use Util\Data\DataProcessingError;
use Util\Data\DataProcessor;
use Util\Value\Enum;

class EnumProcessor implements DataProcessor
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
     * @return mixed
     */
    public function __invoke($in)
    {
        /** @var Enum $class */
        $class = $this->class;

        foreach ($class::getAll() as $enum) {
            if ($enum->getValue() === $in) {
                return $enum;
            }
        }

        throw new DataProcessingError('invalid enum value (valid values: '.implode(', ', $class::getAll()).')');
    }
}
