<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/18
 * Time: 上午10:31
 */

require_once 'vendor/autoload.php';
//require_once 'preg.php';

class_alias('\RedBeanPHP\R','\R');

R::setup( 'mysql:host=localhost;dbname=alone', 'root', 'westos' );
R::setAutoResolve( TRUE );
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});


$i = 1;
$limit = 2000;
while($i){
    $articleInfo = R::findAll('web_article', 'id >= ? LIMIT ?', [$i, $limit]);

    if(empty($articleInfo)) {
        echo 'All completed!',"\r\n";
        sleep(120);
        continue;
    }else {
        $i += $limit;
    }

    foreach ($articleInfo as $article) {

        if(!empty($article['full_url'])) {
            echo 'article full_url exist at id = '.$article->id, "\r\n";
            continue;
        }

        $rawUrl = $article->raw_url;
        $url = $rawUrl;
        if(!isUrl($rawUrl)) {
            $rawInfo = R::findOne('web_raw', 'id = ?', [$article->wid]);
            $urlArr  = parse_url($rawInfo->url);
            $url     = '';
            if(!empty($urlArr['scheme'])) {
                $url .= $urlArr['scheme'].'://';
            }
            if(!empty($urlArr['host'])) {
                $url .= $urlArr['host'];
            }
            $url .= $rawUrl;
        }

        $webArticle = R::xdispense('web_article');
        $webArticle->id = $article->id;
        $webArticle->full_url = $url;
        echo $article->id,"\r\n";
        R::store($webArticle);
    }

}

function isUrl($str)
{
    return strpos($str, '.') === false ? false : true;
}