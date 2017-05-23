<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/22
 * Time: 下午5:14
 */

namespace Crawler;

use GuzzleHttp\Client;
use Log\Log;


/**
 * base crawler on network
 */
class Crawler
{
    protected static $url    = null;
    protected static $method = null;
    protected static $client = null;

    public function __construct()
    {
        self::$client = new Client();
    }

    public function getContent($url, $method=null, $ext=[])
    {
        self::$url    = $url;
        self::$method = $method;
        try {
            $response = self::$client->request($method, $url, $ext);
        } catch (\Exception $e) {
            $log  = $e->getMessage();
            $logContent = 'Failed at pull ' . $url . ' msg: ' . $log ;
            Log::log($logContent);
        }

        return $response;
    }
}