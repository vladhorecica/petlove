<?php

namespace Petlove\ApiBundle\Listener;

use Petlove\Domain\Security\Exception\AuthenticationError;
use Petlove\Domain\Security\Exception\AuthorizationError;
use Util\Data\DataProcessingError;
use Util\Util\Gen;
use Petlove\ApiBundle\Exception\DataInputError;
use Petlove\Domain\Common\Exception\NotFoundError;
use Petlove\Domain\Common\Exception\SoftDeletedResourceError;
use Petlove\Domain\Common\Exception\ValidationError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ExceptionResponseListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof HttpException) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'message' => $exception->getMessage(),
                ],
            ], $exception->getStatusCode()));
        }
        elseif ($exception instanceof AuthenticationError) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'message' => 'Authentication failed',
                ],
            ], JsonResponse::HTTP_UNAUTHORIZED));
        } elseif ($exception instanceof AuthorizationError) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'message' => $exception->getMessage(),
                ],
            ], JsonResponse::HTTP_FORBIDDEN));
        }
        elseif ($exception instanceof DataProcessingError) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'code' => 'input_error',
                    'path' => $exception->getPath(),
                    'message' => $exception->getErrorMessage(),
                ],
            ], JsonResponse::HTTP_CONFLICT));
        } elseif ($exception instanceof NotFoundError || $exception instanceof SoftDeletedResourceError) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'code' => 'not_found',
                    'message' => "The url is valid, but some resource  was not found ({$exception->getMessage()})"
                ],
            ], JsonResponse::HTTP_NOT_FOUND));
        } elseif ($exception instanceof ValidationError) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'code' => 'validation_error',
                    'message' => 'Conflict (validation error)',
                    'violations' => iterator_to_array(
                        Gen::map(
                            $exception->getViolations(),
                            function (ConstraintViolationInterface $violation) {
                                return [
                                    'path' => $violation->getPropertyPath(),
                                    'message' => $violation->getMessage(),
                                ];
                            }
                        )
                    ),
                ],
            ], JsonResponse::HTTP_CONFLICT));
        } elseif ($exception instanceof DataInputError) {
            $event->setResponse(new JsonResponse([
                'code' => 'input_error',
                'errors' => iterator_to_array(
                    Gen::map(
                        $exception->getErrors(),
                        function (DataProcessingError $error) {
                            return [
                                'path' => $error->getPath(),
                                'message' => $error->getMessage(),
                            ];
                        }
                    )
                ),
            ], JsonResponse::HTTP_CONFLICT));
        }
        elseif ($exception instanceof \DomainException) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ],
            ], JsonResponse::HTTP_CONFLICT));
        } else {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTrace()
                ],
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR));
        }
    }
}
