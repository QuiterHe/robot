<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/22
 * Time: 下午5:55
 */

namespace App\CrawIteration;


/**
 * 爬虫迭代器接口
 */
interface CrawIterationInterface
{
    public function next($res);
}