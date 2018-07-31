<?php

namespace Util\Validation;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SimpleValidator
{
    /** @var PropertyAccessor */
    private $propertyAccessor;
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->validator = $validator;
    }

    /**
     * @param mixed $subject
     * @param mixed[] ...$extra
     *
     * @return SimpleValidationViolation[]
     */
    public function validate($subject, ...$extra)
    {
        $v = new SimpleValidation($subject, $this->propertyAccessor, $this->validator);
        $v->validate(...$extra);

        return $v->getViolations();
    }
}
