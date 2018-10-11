<?php

namespace Petlove\Domain\Catalog\Category\Validation;

use Petlove\Domain\Catalog\Category\Validation\Validator\CategoryExistsValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class CategoryExists
 * @package Petlove\Domain\Catalog\Category\Validation
 */
class CategoryExists extends Constraint
{
    public function validatedBy(): string
    {
        return CategoryExistsValidator::class;
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
