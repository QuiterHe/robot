<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/17
 * Time: 下午2:51
 */

require_once 'vendor/autoload.php';
ini_set('memory_limit', '1024M');

use GuzzleHttp\Client;

class_alias('\RedBeanPHP\R','\R');

R::setup( 'mysql:host=localhost;dbname=alone', 'root', 'westos' );
R::setAutoResolve( TRUE );
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});


//$webRaw   = R::xdispense('web_raw');
//$webStuff = R::xdispense('web_stuff');

$i = 0;
$client = new Client();

$a = R::findOne('web_raw', 'order by id desc limit 1');
if(!empty($a->id)) {
    $i = $a->id - 1;
}

while(++$i) {
    $webRaw   = R::xdispense('web_raw');
    $url = 'https://toutiao.io/subjects/'.$i;

    $urlInfo = R::getAll('SELECT * FROM web_raw WHERE url = ? ', [$url]);

    if(!empty($urlInfo)) {
        echo $url,' exist ',"\r\n";
        continue;
    }
    try{
        $response = $client->request('GET', $url, [
            'allow_redirects' => false
        ]);
    }catch(\Exception $e){
        $log  = $e->getMessage();
        $time = date('Ymd', time());
        $msg  = 'Failed at pull ' . $url . ' msg: ' . $log . date('Y-m-d H:i:s', time()) . PHP_EOL;
        file_put_contents(dirname(__FILE__).'/log/'.$time, $msg, FILE_APPEND);
        echo $msg,"\r\n";
//        die();
        continue;
    }

//    $statusCode = $response->getStatusCode();
//    if( 302 != $statusCode ) {
//        $msg  = 'Failed at pull ' . $url . ' msg: ' . 'errorCode: ' . $statusCode . date('Y-m-d H:i:s', time()) . PHP_EOL;
//        $time = date('Ymd', time());
//        file_put_contents('log/'.$time, $msg, FILE_APPEND);
//        echo $msg,"\r\n";
//        continue;
//    }

    $body = (string) $response->getBody();

    $webRaw->web     = 1;
    $webRaw->url     = $url;
    $webRaw->content = $body;

    R::store( $webRaw );

    echo $url,"\r\n";



}

