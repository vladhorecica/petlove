<?php

namespace Petlove\Infrastructure\Common;

interface RedisRepositoryAPI
{
    /**
     * @param string $key
     * @param int $expiration
     */
    public function touch($key, $expiration);

    /**
     * @param string $key
     * @return array
     */
    public function find($key);

    /**
     * @param string $key
     */
    public function delete($key);

    /**
     * @param string $key
     * @param $value
     * @param int|null $expiration
     * @return string
     */
    public function set($key, $value, $expiration = null);

    /**
     * @param string $key
     * @return bool
     */
    public function exists($key);

    /**
     * @param string $key
     * @param $hashKey
     * @return string
     */
    public function get($key, $hashKey);
}
