<?php

namespace Petlove\Domain\BackendUser\Validation;

use Petlove\Domain\BackendUser\Validation\Validator\BackendUserExistsValidator;
use Symfony\Component\Validator\Constraint;

class BackendUserExists extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return BackendUserExistsValidator::class;
    }
}
