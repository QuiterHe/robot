<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/17
 * Time: 下午4:43
 */

require "vendor/autoload.php";
use PHPHtmlParser\Dom;

function parseHtml($html, $url='') {
    $dom = new Dom;
    $dom->loadStr($html ,[]);
    $contents = $dom->find('div[class=post]');

    $data = [];
    foreach ($contents as $content) {
        $dom->loadStr($content->innerHTML, []);
        $likes = $dom->find('a/span')[0]->innerHTML;
        $title = $dom->find('div[class=content]/a')[0]->innerHTML;
        $urls   = $dom->find('div[class=content]/a')[0]->getAttribute('href');
        if(!empty($url)) {
            $urls = getUrl($url) . '/' . $url;
        }
        $data[] = [
            'likes' => $likes,
            'title' => $title,
            'url'   => $urls,

        ];

    }

    return $data;

}

function infoQParseHtml($html, $url='') {
    $dom = new Dom;
    $dom->loadStr($html ,[]);
    $contents = $dom->find('div[class=news_type2 full_screen]');

    $data = [];

    foreach ($contents as $content) {
//        var_dump($content->innerHTML);die();
        $dom->loadStr($content->innerHTML, []);
        $titleInfo = $dom->find('h2/a')[0];
        $remark = $dom->find('div[class=txt]/p')[0]->text;

        $comments  = 0;
        $comment = $dom->find('div[class=txt]/span[class=nr]');
        if(count($comment)) {
            $comments = $comment[0]->innerHTML;
        }

        $author    = $dom->find('a[class=editorlink f_taxonomyEditor]');

        $author    = implode(',', array_map(function($e){return $e->innerHTML;}, $author->toArray()));
        $title = $titleInfo->getAttribute('title');
        $urls  = $titleInfo->getAttribute('href');


        if(!empty($url)) {
            $urls = getUrl($url) . '/' . $url;
        }
        $data[] = [
            'title' => $title,
            'url'   => $urls,
            'author'=> $author,
            'remark'=> $remark,
            'comments' => $comments,

        ];

    }

    return $data;

}

function getUrl($url) {
    $str = $url;
    $str = substr($str, -1) == '/'  ? substr($str, 0, strlen($str)-1) : $str;
    return $str;
}


