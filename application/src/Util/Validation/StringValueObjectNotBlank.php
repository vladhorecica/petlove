<?php
// @codingStandardsIgnoreFile
namespace Util\Validation;

use Util\Value\StringValueObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StringValueObjectNotBlank extends Constraint
{
}

class StringValueObjectNotBlankValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        ($constraint);
        if (!($value instanceof StringValueObject)) {
            return;
        }

        if ($value->getValue() === '') {
            $this->context->addViolation('This value should not be empty');
        }
    }
}
