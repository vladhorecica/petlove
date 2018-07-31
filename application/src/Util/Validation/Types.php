<?php
// @codingStandardsIgnoreFile
namespace Util\Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class Types extends Constraint
{
    /** @var string[] */
    private $types;

    /**
     * @param string[] $types
     */
    public function __construct(array $types)
    {
        parent::__construct();
        $this->types = $types;
    }

    /**
     * @return string[]
     */
    public function getTypes()
    {
        return $this->types;
    }
}

class TypesValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value === null) {
            return;
        }

        if (!($constraint instanceof Types)) {
            throw new \InvalidArgumentException();
        }

        foreach ($constraint->getTypes() as $type) {
            if ($this->isValid($value, $type)) {
                return;
            }
        }

        $this->context->addViolation('invalid type (valid types: '.implode(', ', $constraint->getTypes()).')');
    }

    /**
     * @param mixed $value
     * @param mixed $type
     *
     * @return bool
     */
    private function isValid($value, $type)
    {
        if (is_object($value) && $value instanceof $type) {
            return true;
        }
        if (function_exists("is_$type") && call_user_func("is_$type", $value)) {
            return true;
        }
        if ($type === 'boolean' && is_bool($value)) { // seriously php, where is is_boolean
            return true;
        }

        return false;
    }
}
