<?php

namespace Util\Validation;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Composite;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Util\Exception\ImplementationError;

class SimpleValidation
{
    /** @var mixed */
    private $subject;
    /** @var string */
    private $path;
    /** @var \ArrayObject|SimpleValidationViolation[] */
    private $violations;

    /** @var PropertyAccessor */
    private $propertyAccessor;
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param mixed              $subject
     * @param PropertyAccessor   $propertyAccessor
     * @param ValidatorInterface $validator
     */
    public function __construct($subject, PropertyAccessor $propertyAccessor, ValidatorInterface $validator)
    {
        $this->subject = $subject;
        $this->path = null;
        $this->violations = new \ArrayObject();

        $this->propertyAccessor = $propertyAccessor;
        $this->validator = $validator;
    }

    /**
     * @return SimpleValidationViolation[]
     */
    public function getViolations()
    {
        return $this->violations->getArrayCopy();
    }

    /**
     * @param $property
     *
     * @return self
     */
    public function at($property)
    {
        $validation = clone $this;
        $validation->subject = $this->propertyAccessor->getValue($this->subject, $property);
        $validation->path = $validation->path !== null ? "{$validation->path}.$property" : $property;

        return $validation;
    }

    /**
     * @param Constraint $constraint
     *
     * @return $this
     */
    public function constrain(Constraint $constraint)
    {
        if ($constraint instanceof Valid || $constraint instanceof Composite || $constraint instanceof Callback) {
            throw new ImplementationError('SimpleValidator does not support this constraint');
        }

        if ($constraint->groups !== [Constraint::DEFAULT_GROUP]) {
            throw new ImplementationError('SimpleValidator does not support groups');
        }

        $violations = $this->validator->validate($this->subject, $constraint);
        foreach ($violations as $v) {
            /* @var ConstraintViolationInterface $v */
            $this->violations[] = new SimpleValidationViolation($this->path, $v->getMessage());
        }

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function addViolation($message)
    {
        $this->violations[] = new SimpleValidationViolation($this->path, $message);

        return $this;
    }

    /**
     * @param mixed[] ...$extra
     *
     * @return $this
     */
    public function validate(...$extra)
    {
        if (is_object($this->subject)) {
            $this->subject->validate($this, ...$extra);
        }

        return $this;
    }

    /**
     * @param callable $cb
     *
     * @return $this
     */
    public function each(callable $cb)
    {
        if (is_array($this->subject) || $this->subject instanceof \Traversable) {
            foreach ($this->subject as $k => $v) {
                $validation = clone $this;
                $validation->subject = $v;
                $validation->path .= "[$k]";
                $cb($validation);
            }
        }

        return $this;
    }
}
