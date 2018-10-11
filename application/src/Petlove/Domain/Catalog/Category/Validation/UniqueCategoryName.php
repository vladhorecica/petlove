<?php

namespace Petlove\Domain\Catalog\Category\Validation;

use Petlove\Domain\Catalog\Category\Validation\Validator\UniqueCategoryNameValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueCategoryName
 * @package Petlove\Domain\Catalog\Category\Validation
 */
class UniqueCategoryName extends Constraint
{
    public function validatedBy(): string
    {
        return UniqueCategoryNameValidator::class;
    }
}
