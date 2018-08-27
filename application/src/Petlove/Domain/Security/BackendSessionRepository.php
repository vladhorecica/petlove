<?php

namespace Petlove\Domain\Security;

use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Security\Value\SessionId;

interface BackendSessionRepository
{
    /**
     * @param BackendUserId $backendUserId
     *
     * @return SessionId
     */
    public function create(BackendUserId $backendUserId);

    /**
     * @param SessionId $sessionId
     */
    public function touch(SessionId $sessionId);

    /**
     * @param SessionId $sessionId
     *
     * @return BackendSession
     */
    public function find(SessionId $sessionId);

    /**
     * @param SessionId $sessionId
     */
    public function delete(SessionId $sessionId);
}
