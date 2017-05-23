<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/18
 * Time: 下午6:49
 */

require_once 'vendor/autoload.php';
ini_set('memory_limit', '1024M');

use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class_alias('\RedBeanPHP\R','\R');

R::setup( 'mysql:host=localhost;dbname=alone', 'root', 'westos' );
R::setAutoResolve( TRUE );
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});


//$webRaw   = R::xdispense('web_raw');
//$webStuff = R::xdispense('web_stuff');

//$i = 0;
//$client = new Client();

//$a = R::findOne('web_raw', 'web = 1 order by id desc limit 1');
//if(!empty($a->id)) {
//    $i = $a->id - 1;
//}

run();

function run()
{
    $i = 0;
    $step = 9;
    while($i += $step) {
        $page = $i - $step;
        $url = 'http://www.infoq.com/cn/articles/'.$page;

        $urlInfo = R::getAll('SELECT * FROM web_raw WHERE url = ? ', [$url]);

        if(!empty($urlInfo)) {
            echo $url,' exist ',"\r\n";
//            getPage($url);
            continue;
        }

        $content = getWebContent($url);
        if(empty($content)) {
            continue;
        }

        $data = [
            'table' => 'web_raw',
            'web'   => 2,
            'url'   => $url,
            'response' => $content,
        ];
        store($data);

//        getPage($url);

    }
}

function getWebContent($url)
{
    $client = new Client();
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
        return false;
    }

    return $response;
}

function store($data)
{
    $webRaw   = R::xdispense($data['table']);

    $response = $data['response'];
    $body     = (string) $response->getBody();

    $webRaw->web     = $data['web'];
    $webRaw->url     = $data['url'];
    $webRaw->content = $body;

    R::store( $webRaw );
    echo $data['url'],"\r\n";
}