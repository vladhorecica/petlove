<?php

namespace Petlove\Domain\Security\Command;

use Petlove\Domain\Security\Value\SessionId;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DeleteSession
{
    /**
     * @var SessionId
     */
    private $session;

    /**
     * DeleteSession constructor.
     *
     * @param SessionId $session
     */
    public function __construct(SessionId $session)
    {
        $this->session = $session;
    }

    /**
     * @return SessionId
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('session', [
            new NotNull(),
            new Type(SessionId::class),
        ]);
    }
}
