<?php

namespace Petlove\Infrastructure\Security;

use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Common\Exception\NotFoundError;
use Petlove\Domain\Security\Value\SessionId;

abstract class RedisSessionRepository
{
    /** @var \Redis */
    private $redis;

    /**
     * @param \Redis $redis
     */
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @return \Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }

    /**
     * @param SessionId $sessionId
     * @throws \Exception
     */
    public function touch(SessionId $sessionId)
    {
        $expiration = (new \DateTimeImmutable())->modify('+1 hour')->getTimestamp();
        $this->redis->expireAt("sessions.$sessionId", $expiration);
    }

    /**
     * @param SessionId $sessionId
     *
     * @return mixed[]
     */
    public function find(SessionId $sessionId)
    {
        $data = $this->redis->hGetAll("sessions.$sessionId");

        if (!$data) {
            throw new NotFoundError();
        }

        return $data;
    }

    /**
     * @param SessionId $sessionId
     */
    public function delete(SessionId $sessionId)
    {
        $this->redis->delete("sessions.$sessionId");
    }

    /**
     * @param BackendUserId $userId
     *
     * @return SessionId
     * @throws \Exception
     */
    protected function createSession($userId)
    {
        $sessionId = new SessionId($this->generateSecret(32));

        $this->redis->hMset("sessions.$sessionId", [
            'user' => (string) $userId,
            'created_at' => time(),
        ]);

        $this->touch($sessionId);

        return $sessionId;
    }

    /**
     * @param $length
     *
     * @return string
     */
    private function generateSecret($length)
    {
        return bin2hex(random_bytes($length));
    }
}
