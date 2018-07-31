<?php

namespace Petlove\Domain\BackendUser\Validation\Validator;

use Petlove\Domain\BackendUser\BackendUserLightSpecification;
use Petlove\Domain\BackendUser\BackendUserRepository;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Validation\UniqueBackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueBackendUserEmailValidator extends ConstraintValidator
{
    /**
     * @var BackendUserLightSpecification
     */
    private $userSpec;

    /**
     * @var BackendUserRepository
     */
    private $userRepository;

    /**
     * BackendUserExistsValidator constructor.
     *
     * @param BackendUserLightSpecification $userSpec
     * @param BackendUserRepository         $userRepository
     */
    public function __construct(BackendUserLightSpecification $userSpec, BackendUserRepository $userRepository)
    {
        $this->userSpec = $userSpec;
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueBackendUserEmail) {
            throw new \InvalidArgumentException();
        }

        $root = $this->context->getRoot();
        if ($root instanceof UpdateBackendUser) {
            $user = $this->userRepository->find($root->getId());
            if ($user->getEmail()->equals($root->getEmail())) {
                // prevent triggering uniqueness violation on the same entity
                return;
            }
        }

        if ($this->userSpec->existsByEmail(new BackendUserEmail($value))) {
            $this->context->addViolation('backend_user_email_must_be_unique: '.$value);
        }
    }
}
