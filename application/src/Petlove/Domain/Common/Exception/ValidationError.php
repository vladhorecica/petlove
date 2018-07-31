<?php

namespace Petlove\Domain\Common\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationError extends \RuntimeException
{
    /** @var ConstraintViolationListInterface */
    private $violations;

    /**
     * @param ConstraintViolationListInterface $violations
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct((string) $violations);
        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }
}
