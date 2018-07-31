<?php

namespace Petlove\Domain\BackendUser\Validation\Validator;

use Petlove\Domain\BackendUser\BackendUserLightSpecification;
use Petlove\Domain\BackendUser\Validation\BackendUserExists;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BackendUserExistsValidator extends ConstraintValidator
{
    /**
     * @var BackendUserLightSpecification
     */
    private $userSpec;

    /**
     * BackendUserExistsValidator constructor.
     *
     * @param BackendUserLightSpecification $userSpec
     */
    public function __construct(BackendUserLightSpecification $userSpec)
    {
        $this->userSpec = $userSpec;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BackendUserExists) {
            throw new \InvalidArgumentException();
        }

        if (!$this->userSpec->exists(new BackendUserId($value))) {
            $this->context->addViolation('backend_user_does_not_exist : '.$value);
        }
    }
}
