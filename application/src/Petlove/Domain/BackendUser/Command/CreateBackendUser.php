<?php

namespace Petlove\Domain\BackendUser\Command;

use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CreateBackendUser
{
    /** @var BackendUserType */
    private $type;

    /** @var BackendUserEmail */
    private $email;

    /** @var string */
    private $password;

    /** @var BackendUserUsername */
    private $username;

    /**
     * CreateBackendUser constructor.
     *
     *
     * @param BackendUserEmail    $email
     * @param BackendUserUsername $username
     * @param string              $password
     * @param BackendUserType     $type
     */
    public function __construct(
        BackendUserEmail $email,
        BackendUserUsername $username,
        $password,
        BackendUserType $type
    ) {
        $this->type = $type;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
    }

    /**
     * @return BackendUserType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return BackendUserEmail
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return BackendUserUsername
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('type', [
            new NotNull(),
            new Type(BackendUserType::class),
        ]);

        $metadata->addPropertyConstraints('email', [
            new NotNull(),
            new Type(BackendUserEmail::class),
            new Valid(),
        ]);

        $metadata->addPropertyConstraints('password', [
            new NotNull(),
            new Type('string'),
        ]);

        $metadata->addPropertyConstraints('username', [
            new NotNull(),
            new Type(BackendUserUsername::class),
            new Valid(),
        ]);
    }
}
