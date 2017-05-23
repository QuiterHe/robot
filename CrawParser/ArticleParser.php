<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/23
 * Time: 上午9:53
 */

namespace App\CrawParser;


class ArticleParser extends HtmlParser
{
    public function parse($content, $parser)
    {
        return $parser->parse($content);
    }
}