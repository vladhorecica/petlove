<?php

namespace Petlove\Infrastructure\Common\Helper;

class UrlHelper
{
    /**
     * @var array
     */
    private static $cache = [];
    /**
     * @param string $url
     * @return bool
     */
    public static function urlExists($url)
    {
        if (isset(self::$cache[$url])) {
            return self::$cache[$url];
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return self::$cache[$url] = ($code === 200 || $code === 301 || $code === 302);
    }
}
