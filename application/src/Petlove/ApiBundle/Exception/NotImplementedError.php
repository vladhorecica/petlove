<?php

namespace Petlove\ApiBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NotImplementedError extends HttpException
{
    /**
     * NotImplementedError constructor.
     *
     * @param string $message
     */
    public function __construct($message = 'Not implemented')
    {
        parent::__construct(Response::HTTP_NOT_IMPLEMENTED, $message);
    }
}
