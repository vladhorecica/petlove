<?php

namespace Petlove\Domain\BackendUser\Validation\Validator;

use Petlove\Domain\BackendUser\BackendUserLightSpecification;
use Petlove\Domain\BackendUser\BackendUserRepository;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Validation\UniqueBackendUserUsername;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueBackendUserUsernameValidator extends ConstraintValidator
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
        if (!$constraint instanceof UniqueBackendUserUsername) {
            throw new \InvalidArgumentException();
        }

        $root = $this->context->getRoot();
        if ($root instanceof UpdateBackendUser) {
            $user = $this->userRepository->find($root->getId());
            if ($user->getUsername()->equals($root->getUsername())) {
                // prevent triggering uniqueness violation on the same entity
                return;
            }
        }

        if ($this->userSpec->existsByUsername(new BackendUserUsername($value))) {
            $this->context->addViolation('backend_user_username_must_be_unique: '.$value);
        }
    }
}
