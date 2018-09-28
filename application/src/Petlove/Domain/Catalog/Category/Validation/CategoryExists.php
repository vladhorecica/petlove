<?php

namespace Petlove\Domain\Catalog\Category\Validation;

use Petlove\Domain\Catalog\Category\Validation\Validator\CategoryExistsValidator;
use Symfony\Component\Validator\Constraint;

class CategoryExists extends Constraint
{
    public function validatedBy(): string
    {
        return CategoryExistsValidator::class;
    }
}
