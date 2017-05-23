<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/23
 * Time: 上午11:41
 */

namespace App\Library;


class UrlHelper
{

    /**
     * 去除URL最后的'/'
     *
     */
    public static function getUrl($url) {
    $str = $url;
    $str = substr($str, -1) == '/'  ? substr($str, 0, strlen($str)-1) : $str;
    return $str;
}
}