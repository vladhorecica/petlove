<?php

namespace Petlove\Domain\BackendUser\Validation;

use Petlove\Domain\BackendUser\Validation\Validator\UniqueBackendUserEmailValidator;
use Symfony\Component\Validator\Constraint;

class UniqueBackendUserEmail extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return UniqueBackendUserEmailValidator::class;
    }
}
