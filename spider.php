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
    $client = new Client();
//    $dom = new Dom;
    $i = 232061;
    while(++$i) {
//        $webRaw   = R::xdispense('web_raw');
        $url = 'https://toutiao.io/subjects/'.$i;

        $urlInfo = R::findAll('web_raw','url = ? ', [$url]);

        if(!empty($urlInfo)) {
            echo $url,' exist ',"\r\n";
            getPage($url, $client);
            continue;
        }

        $content = getWebContent($url, $client);
        if(empty($content)) {
            continue;
        }

        $data = [
            'table' => 'web_raw',
            'web'   => 1,
            'url'   => $url,
            'response' => $content,
        ];
        store($data);

        getPage($url, $client);

        echo $url,"\r\n";

    }
}


function getWebContent($url ,$client)
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

function getPage($url, $client) {
    $j = 1;
    $dom = new Dom();
    while ($j++) {
        $inUrl = $url.'?page='.$j;
        $urlInfo = R::findAll('web_raw','url = ? ', [$inUrl]);

        if(!empty($urlInfo)) {
            echo $inUrl,' (page) exist ',"\r\n";
            continue;
        }

        $content = getWebContent($inUrl, $client);
        $body    = (string) $content->getBody();
//        $dom = new Dom;
        $dom->loadStr($body ,[]);
        $post = $dom->find('div[class=post]');
        $count = count($post);
        if(empty($count)) {
            echo $inUrl,' (page) no content ',"\r\n";
            break;
        }

        $data = [
            'table' => 'web_raw',
            'web'   => 1,
            'url'   => $inUrl,
            'response' => $content,
        ];
        store($data);

//        echo $inUrl,"\r\n";
    }
}