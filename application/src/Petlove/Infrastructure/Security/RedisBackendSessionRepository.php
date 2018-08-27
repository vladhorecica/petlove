<?php

namespace Petlove\Infrastructure\Security;

use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Security\BackendSession;
use Petlove\Domain\Security\BackendSessionRepository;
use Petlove\Domain\Security\Value\SessionId;

class RedisBackendSessionRepository extends RedisSessionRepository implements BackendSessionRepository
{
    /**
     * @param BackendUserId $backendUserId
     *
     * @return SessionId
     * @throws \Exception
     */
    public function create(BackendUserId $backendUserId)
    {
        return parent::createSession($backendUserId);
    }

    /**
     * @param SessionId $sessionId
     *
     * @return BackendSession
     * @throws \Exception
     */
    public function find(SessionId $sessionId)
    {
        $data = parent::find($sessionId);

        return new BackendSession(
            $sessionId,
            new BackendUserId((int) $data['user']),
            (new \DateTimeImmutable())->setTimestamp($data['created_at'])
        );
    }
}
