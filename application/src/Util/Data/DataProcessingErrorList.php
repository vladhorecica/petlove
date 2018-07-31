<?php

namespace Util\Data;

class DataProcessingErrorList implements \IteratorAggregate
{
    private $errors;

    /**
     * @param DataProcessingError $dataProcessingError
     */
    public function add(DataProcessingError $dataProcessingError)
    {
        $this->errors[] = $dataProcessingError;
    }

    /**
     * Converts the violation into a string for debugging purposes.
     *
     * @return string The violation as string
     */
    public function __toString()
    {
        $string = '';

        foreach ($this->errors as $error) {
            $string .= $error."\n";
        }

        return $string;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->errors);
    }
}
