<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/22
 * Time: 下午6:45
 */

namespace App\CrawParser;
//use use PHPHtmlParser\Dom;

class HtmlParser implements CrawParserInterface
{
    private $parser;
    private $content;
    private $result = null;

    public function parse($content, $parser)
    {
        // TODO
    }

}