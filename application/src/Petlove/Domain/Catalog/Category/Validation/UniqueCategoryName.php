<?php

namespace Petlove\Domain\Catalog\Category\Validation;

use Petlove\Domain\Catalog\Category\Validation\Validator\UniqueCategoryNameValidator;
use Symfony\Component\Validator\Constraint;

class UniqueCategoryName extends Constraint
{
    public function validatedBy(): string
    {
        return UniqueCategoryNameValidator::class;
    }
}
