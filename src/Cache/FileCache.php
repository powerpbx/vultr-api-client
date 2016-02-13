<?php

/**
 * Vultr.com Curl File Cache
 *
 * NOTE: this cache adapter was extracted from
 * https://github.com/usefulz/vultr-api-client and updated for PSR compliance.
 *
 * @package Vultr
 * @version 1.0
 * @author  https://github.com/usefulz
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see     https://github.com/malc0mn/vultr-api-client
 */

namespace Vultr\Cache;

class FileCache implements CacheInterface
{
    /**
     * Cache folder
     *
     * @var string Cache dir
     */
    const CACHEDIR = '/tmp/vultr-api-client-cache';

    /**
     * Cache ttl for all get requests
     *
     * @var integer TTL in seconds
     */
    private $cacheTtl;

    /**
     * @param integer $cacheTtl
     */
    public function __construct($cacheTtl = 3600)
    {
        $this->cacheTtl = $cacheTtl;
    }

    /**
     * @param $url
     * @return bool|mixed
     */
    protected function serveFromCache($url)
    {
        // Garbage collect 5% of the time
        if (mt_rand(0, 19) == 0) {
            $files = glob(self::CACHEDIR . '/*');
            $old = time() - ($this->cacheTtl * 2);
            foreach($files as $file)
            {
                if (filemtime($file) < $old) {
                    unlink($old);
                }
            }
        }

        $hash = md5($url);
        $group = $this->groupFromUrl($url);
        $file = self::CACHEDIR . "/$group-$hash";
        if (file_exists($file) && filemtime($file) > (time() - $this->cacheTtl)) {
            $response = file_get_contents($file);
            $obj = json_decode($response, true);
            return $obj;
        }

        return false;
    }

    /**
     * @param $url
     * @param $json
     */
    protected function saveToCache($url, $json)
    {
        if (!file_exists(self::CACHEDIR)) {
            mkdir(self::CACHEDIR);
        }

        $hash = md5($url);
        $group = $this->groupFromUrl($url);
        $file = self::CACHEDIR . "/$group-$hash";
        file_put_contents($file, $json);
    }

    /**
     * @param $url
     * @return string
     */
    protected function groupFromUrl($url)
    {
        if (preg_match('@/v1/([^/]+)/@', $url, $match)) {
            return $match[1];
        }

        return 'default';
    }

    /**
     * @param $url
     */
    protected function purgeCache($url)
    {
        $group = $this->groupFromUrl($url);
        $files = glob(self::CACHEDIR . "/$group-*");
        foreach($files as $file) {
            unlink($file);
        }
    }

    /**
     * Write last access.
     */
    protected function writeLast()
    {
        if (!file_exists(self::CACHEDIR)) {
           mkdir(self::CACHEDIR);
        }

        file_put_contents(self::CACHEDIR . '/last', time());
    }

    /**
     * @return string
     */
    protected function readLast()
    {
        if (file_exists(self::CACHEDIR . '/last')) {
            return file_get_contents(self::CACHEDIR . '/last');
        }

        return 0;
    }
}
