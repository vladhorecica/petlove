<?php

namespace Petlove\Domain\Security\Exception;

use Throwable;

/**
 * Class AuthenticationError
 * @package Petlove\Domain\Security\Exception
 */
class AuthenticationError extends \RuntimeException
{
    public function __construct(
        string $message = "Must be authenticated.",
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
