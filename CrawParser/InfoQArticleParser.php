<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/23
 * Time: 上午11:19
 */

namespace App\CrawParser;
use PHPHtmlParser\Dom;
use App\Library\UrlHelper;

class InfoQArticleParser
{
    protected $dom;

    public function __construct()
    {
        $this->dom = new Dom;
    }

    public function parse($html)
    {
        $dom = $this->dom;
        $dom->loadStr($html, []);
        $articles = $dom->find('div[class=news_type2 full_screen]');

        if(!count($articles)){
            return [];
        }

        $data = [];
        foreach ($articles as $content) {
            $dom->loadStr($content->innerHTML, []);

            // url 和 title
            if(count($titleInfo = $dom->find('h2/a'))) {
                $titleInfo = $titleInfo[0];
                $title = $titleInfo->getAttribute('title');
                $urls  = $titleInfo->getAttribute('href');
            }

            // 摘要
            if(count($remark = $dom->find('div[class=txt]/p'))) {
                $remark = $remark[0]->text;

            }

            $comments  = 0;
            $comment   = $dom->find('div[class=txt]/span[class=nr]');
            if(count($comment)) {
                $comments = $comment[0]->innerHTML;
            }

            $author    = $dom->find('a[class=editorlink f_taxonomyEditor]');

            $author    = implode(',', array_map(function($e){return $e->innerHTML;}, $author->toArray()));

            if(!empty($url)) {
                $urls = UrlHelper::getUrl($url) . '/' . $url;
            }
            $data[] = [
                'title' => isset($title) ? $title : '',
                'url'   => isset($urls)  ? $urls  : '',
                'author'=> $author,
                'remark'=> $remark,
                'comments' => $comments,

            ];

        }
        return $data;
    }
}