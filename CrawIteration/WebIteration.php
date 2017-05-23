<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/22
 * Time: 下午5:57
 */

namespace App\CrawIteration;

/**
 * web爬虫迭代器
 */
class WebIteration implements CrawIterationInterface
{
    protected $list = [];
    protected $pos;

    public function next($res)
    {
        // TODO: Implement next() method.
        $next = $res->next;
        $this->run($next);
        return $next;
    }

    public function run($next)
    {
        $pos = array_push($this->list, $next);
        return $this->pos=$pos;
    }
}