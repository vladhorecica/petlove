<?php

namespace Util\Validation;

class SimpleValidationError extends \Exception
{
    /** @var SimpleValidationViolation[] */
    private $violations;

    /**
     * @param SimpleValidationViolation[] $violations
     */
    public function __construct(array $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @return SimpleValidationViolation[]
     */
    public function getViolations()
    {
        return $this->violations;
    }
}
