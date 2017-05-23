<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/18
 * Time: 上午11:35
 */

require_once 'vendor/autoload.php';
//require_once 'preg.php';

use GuzzleHttp\Client;

class_alias('\RedBeanPHP\R','\R');

R::setup( 'mysql:host=localhost;dbname=alone', 'root', 'westos' );
R::setAutoResolve( TRUE );
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});


$i = 1;
$limit = 5000;

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

        if(!empty($article['real_url'])) {
            echo 'article real_url exist at id = '.$article->id, "\r\n";
            continue;
        }

        $fullUrl = $article->full_url;

        $realUrl = getRealUrl($fullUrl);

        $webArticle = R::xdispense('web_article');
        $webArticle->id = $article->id;
        $webArticle->real_url = $realUrl;
        echo $article->id,"\r",$realUrl,"\r\n";
        R::store($webArticle);

    }

}

function getRealUrl($url) {
    $client = new Client();
    try{
        $response = $client->request('GET', $url, [
            'allow_redirects' => false
        ]);
    }catch(\Exception $e){
        $log  = $e->getMessage();
        $time = date('Ymd', time());
        $msg  = 'Failed at pull ' . $url . ' msg: ' . $log . date('Y-m-d H:i:s', time()) . PHP_EOL;
        file_put_contents(dirname(__FILE__).'/log/'.' real_url '.$time, $msg, FILE_APPEND);
        echo $msg,"\r\n";
        return false;
    }

    $location = $response->getHeader('Location');
    if( empty($location) ) {
        $log  = $e->getMessage();
        $time = date('Ymd', time());
        $msg  = 'Failed at location ' . $url . ' msg: ' . $log . date('Y-m-d H:i:s', time()) . PHP_EOL;
        file_put_contents(dirname(__FILE__).'/log/'.' real_url '.$time, $msg, FILE_APPEND);
        echo $msg,"\r\n";
        return false;
    }

    $location = current($location);

    return $location;
}