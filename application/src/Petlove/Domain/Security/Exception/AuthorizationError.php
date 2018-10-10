<?php

namespace Petlove\Domain\Security\Exception;

use Throwable;

/**
 * Class AuthorizationError
 * @package Petlove\Domain\Security\Exception
 */
class AuthorizationError extends \RuntimeException
{
    public function __construct(
        string $message = "Not authorized for this action.",
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
