<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/22
 * Time: 下午6:22
 */

require_once 'vendor/autoload.php';

//$iteration = new App\CrawIteration\WebIteration();
//
//$iteration->run();
class_alias('\RedBeanPHP\R','\R');

R::setup( 'mysql:host=localhost;dbname=alone', 'root', 'westos' );
R::setAutoResolve( TRUE );
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});

$parser = new \App\CrawParser\InfoQArticleParser();

$article = R::findOne('web_raw', 'id=244239');
$content = $article->content;

$articles = new \App\CrawParser\ArticleParser();

$a = $articles->parse($content, $parser);

var_dump($a);