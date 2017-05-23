<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/17
 * Time: 下午4:19
 */

require_once 'vendor/autoload.php';
require_once 'preg.php';

class_alias('\RedBeanPHP\R','\R');

R::setup( 'mysql:host=localhost;dbname=alone', 'root', 'westos' );
R::setAutoResolve( TRUE );
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});

//$webRaw     = R::xdispense('web_raw');



$i = 1;
$a = R::findOne('web_article', 'order by id desc ');
if(!empty($a->wid)) {
    $i = $a->wid - 1;
}

$limit = 100;
while($i){
    $rawInfo = R::findAll('web_raw', 'id >= ? LIMIT ?', [$i, $limit]);

    if(empty($rawInfo)) {
        echo $i;
        echo 'All completed!',"\r\n";
        sleep(120);
//        continue;
    }else {
        $i += $limit;
    }

    if( !empty($rawInfo) ) {

        foreach ($rawInfo as $webInfo) {

            $articleInfo = R::findOne('web_article', 'wid = ?', [$webInfo->id]);
            if(!empty($articleInfo)) {
                echo 'article exist at wid = '.$articleInfo->wid, "\r\n";
                continue;
            }

           $rawContent = $webInfo['content'];
//           $rawUrl     = $webInfo['url'];

           $data = infoQParseHtml($rawContent);

           foreach ($data as $article) {
               $webArticle = R::xdispense('web_article');
               $webArticle->wid     = $webInfo->id;
               $webArticle->author  = $article['author'];
               $webArticle->title   = $article['title'];
               $webArticle->raw_url = $article['url'];
               $webArticle->remark  = $article['remark'];
               $webArticle->comments= $article['comments'];

               R::store($webArticle);
               echo $article['title'],"\r\n";

           }

        }
    }

}


