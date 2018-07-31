<?php

namespace Petlove\Infrastructure\Common;

class RedisRepository implements RedisRepositoryAPI
{
    /** @var \Redis */
    protected $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param string $key
     * @param int $expiration
     */
    public function touch($key, $expiration)
    {
        $this->redis->expireAt($key, $expiration);
    }

    /**
     * @param string $key
     * @return array
     */
    public function find($key)
    {
        $data = $this->redis->hGetAll($key);

        return $data;
    }

    /**
     * @param string $key
     */
    public function delete($key)
    {
        $this->redis->delete($key);
    }

    /**
     * @param string $key
     * @param string|array $value
     * @param int|null $expiration
     * @return string
     */
    public function set($key, $value, $expiration = null)
    {
        $this->redis->hMset($key, $value);
        if ($expiration) {
            $this->touch($key, $expiration);
        }

        return $key;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exists($key)
    {
        $data = $this->redis->exists($key);

        return $data;
    }

    /**
     * @param string $key
     * @param $hashKey
     * @return string
     */
    public function get($key, $hashKey)
    {
        $data = $this->redis->hGet($key, $hashKey);

        return $data;
    }
}
