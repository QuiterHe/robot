<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/22
 * Time: 下午6:43
 */

namespace App\CrawParser;

/**
 * 爬虫内容解析
 */
interface CrawParserInterface
{
    public function parse($content, $parser);
}