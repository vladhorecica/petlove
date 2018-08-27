<?php

namespace Petlove\Domain\Security;

use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Security\Value\SessionId;

class BackendSession
{
    /** @var SessionId */
    private $id;
    /** @var BackendUserId */
    private $backendUser;
    /** @var \DateTimeImmutable */
    private $createdAt;

    /**
     * Session constructor.
     *
     * @param SessionId          $id
     * @param BackendUserId      $backendUser
     * @param \DateTimeImmutable $createdAt
     */
    public function __construct(SessionId $id, BackendUserId $backendUser, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->backendUser = $backendUser;
        $this->createdAt = $createdAt;
    }

    /**
     * @return SessionId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return BackendUserId
     */
    public function getBackendUser()
    {
        return $this->backendUser;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
