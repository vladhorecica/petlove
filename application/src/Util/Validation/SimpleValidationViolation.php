<?php

namespace Util\Validation;

class SimpleValidationViolation
{
    /** @var string */
    private $path;
    /** @var string */
    private $message;

    /**
     * @param string $path
     * @param string $message
     */
    public function __construct($path, $message)
    {
        $this->path = $path;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
