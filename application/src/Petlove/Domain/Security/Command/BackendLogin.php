<?php

namespace Petlove\Domain\Security\Command;

use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class BackendLogin
{
    /**
     * @var BackendUserEmail
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * BackendLogin constructor.
     *
     * @param BackendUserEmail $email
     * @param string           $password
     */
    public function __construct(BackendUserEmail $email, $password)
    {
        $this->email = $email;
        $this->password = $password;
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
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('email', [
            new NotNull(),
            new Type(BackendUserEmail::class),
            new Email(),
        ]);

        $metadata->addPropertyConstraints('password', [
            new NotNull(),
            new Type('string'),
        ]);
    }
}
