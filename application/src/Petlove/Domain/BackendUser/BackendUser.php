<?php

namespace Petlove\Domain\BackendUser;

use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;

class BackendUser implements \JsonSerializable
{
    /** @var BackendUserId */
    private $id;

    /** @var BackendUserType */
    private $type;

    /** @var BackendUserEmail */
    private $email;

    /** @var string */
    private $password;

    /** @var BackendUserUsername */
    private $username;

    /**
     * BackendUser constructor.
     *
     * @param BackendUserId $id
     * @param BackendUserUsername $username
     * @param BackendUserEmail $email
     * @param string $password
     * @param BackendUserType $type
     */
    public function __construct(
        BackendUserId $id,
        BackendUserUsername $username,
        BackendUserEmail $email,
        string $password,
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
    public function getId(): BackendUserId
    {
        return $this->id;
    }

    /**
     * @return BackendUserType
     */
    public function getType(): BackendUserType
    {
        return $this->type;
    }

    /**
     * @return BackendUserEmail
     */
    public function getEmail(): BackendUserEmail
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return BackendUserUsername
     */
    public function getUsername(): BackendUserUsername
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'type' => $this->type
        ];
    }
}
