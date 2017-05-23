<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/22
 * Time: 下午5:28
 */

namespace Log;


class Log
{
    public static function log($content, $sort=null)
    {
        $time = date('Ymd', time());
        $msg  = $content . date('Y-m-d H:i:s', time()) . PHP_EOL;
        file_put_contents(dirname(__FILE__) . '/log/' . 'pull_' .$time, $msg, FILE_APPEND);
    }
}