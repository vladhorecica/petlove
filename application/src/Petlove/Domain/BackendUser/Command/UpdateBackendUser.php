<?php

namespace Petlove\Domain\BackendUser\Command;

use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class UpdateBackendUser
{
    /** @var BackendUserId */
    private $id;

    /** @var BackendUserEmail */
    private $email;

    /** @var BackendUserUsername */
    private $username;

    /** @var string */
    private $password;

    /** @var BackendUserType */
    private $type;

    /**
     * UpdateBackendUser constructor.
     * @param BackendUserId $id
     * @param BackendUserEmail $email
     * @param BackendUserUsername $username
     * @param string|null $password
     * @param BackendUserType $type
     */
    public function __construct(
        BackendUserId $id,
        BackendUserEmail $email,
        BackendUserUsername $username,
        $password,
        BackendUserType $type
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
    }

    /**
     * @return BackendUserId
     */
    public function getId()
    {
        return $this->id;
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
        $metadata->addPropertyConstraints('id', [
            new NotNull(),
            new Type(BackendUserId::class),
            new Valid(),
        ]);

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
            new Type('string'),
        ]);

        $metadata->addPropertyConstraints('username', [
            new NotNull(),
            new Type(BackendUserUsername::class),
            new Valid(),
        ]);
    }
}
