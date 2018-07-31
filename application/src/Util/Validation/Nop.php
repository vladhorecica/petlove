<?php
// @codingStandardsIgnoreFile
namespace Util\Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class Nop extends Constraint
{
}

class NopValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        // nop
    }
}
