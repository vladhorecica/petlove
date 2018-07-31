<?php

namespace Util\Data;

class DataProcessingError extends \RuntimeException
{
    /** @var string[] */
    private $path;
    /** @var string */
    private $errorMessage;

    /**
     * @param string   $errorMessage
     * @param string[] $path
     */
    public function __construct($errorMessage, array $path = [])
    {
        parent::__construct($errorMessage);
        $this->path = $path;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string[]
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
