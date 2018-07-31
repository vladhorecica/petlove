<?php

namespace Petlove\Domain\BackendUser\Validation;

use Petlove\Domain\BackendUser\Validation\Validator\UniqueBackendUserUsernameValidator;
use Symfony\Component\Validator\Constraint;

class UniqueBackendUserUsername extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return UniqueBackendUserUsernameValidator::class;
    }
}
