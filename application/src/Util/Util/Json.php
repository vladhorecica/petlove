<?php
// @codingStandardsIgnoreFile
namespace Util\Util;

class JsonError extends \RuntimeException
{
}

abstract class Json
{
    /**
     * @param string $json
     *
     * @return mixed
     */
    public static function decode($json)
    {
        $decoded = json_decode($json, true);
        if (json_last_error()) {
            throw new JsonError(json_last_error_msg());
        }

        return $decoded;
    }
}
