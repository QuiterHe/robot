<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/21
 * Time: 上午11:18
 */

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

//$url = 'http://124.243.249.4/rest/n/magicFace?mod=HUAWEI(KNT-AL20)&lon=0&country_code=CN&did=ANDROID_f0c3da7ce59666ce&net=WIFI&app=0&oc=HUAWEI&ud=461564273&c=HUAWEI&sys=ANDROID_7.0&appver=4.56.2.4348&language=zh-cn&lat=0&ver=4.56';
//$url = 'http://124.243.249.4/rest/n/feed/list?mod=HUAWEI(KNT-AL20)&lon=0&country_code=CN&did=ANDROID_f0c3da7ce59666ce&net=WIFI&app=0&oc=HUAWEI&ud=461564273&c=HUAWEI&sys=ANDROID_7.0&appver=4.56.2.4348&language=zh-cn&lat=0&ver=4.56';

//$response = $client->request('POST', $url, [
//
//    'headers' => [
//       'X-REQUESTID'  => '1023089106',
//       'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8 ',
//    ],
//
//    'form_params' => [
//        'client_key' => '3c2cd3f3',
//        'token'      => 'd7b48c6444974bd997808684b7256215-461564273',
//        'os'         => 'android',
//        'sig'        => 'e8f6dd5c1e0c2d2d9574b86e5ed6e179',
//    ],
//
//]);
//
//
//$response = $client->request('POST', $url, [
//
//    'headers' => [
//       'X-REQUESTID'  => '1023093278',
//       'Content-Type' => 'application/x-www-form-urlencoded',
//    ],
//
//    'form_params' => [
//        'type'       => '7',
//        'page'       => '2',
//        'count'      => '20',
//        'pv'         => 'false',
//        'id'         => '994',
//        'pcursor'    => '',
//        'token'      => 'd7b48c6444974bd997808684b7256215-461564273',
//        'client_key' => '3c2cd3f3',
//        'os'         => 'android',
//        'sig'        => '2ba89b1b45e0e47adadf3753d6717954',
//    ],
//
//]);

// 列表
if(isset($_SERVER['list'])) {

    $url = 'http://124.243.249.4/rest/n/feed/list?mod=HUAWEI(KNT-AL20)&lon=0&country_code=CN&did=ANDROID_f0c3da7ce59666ce&net=WIFI&app=0&oc=HUAWEI&ud=461564273&c=HUAWEI&sys=ANDROID_7.0&appver=4.56.2.4348&language=zh-cn&lat=0&ver=4.56';
    $response = $client->request('POST', $url, [

        'headers' => [
           'X-REQUESTID'  => '1023093278',
           'Content-Type' => 'application/x-www-form-urlencoded',
        ],

        'form_params' => [
            'type'       => '7',
            'page'       => '1',
            'count'      => '20',
            'pv'         => 'false',
            'id'         => '993',
            'pcursor'    => '',
            'token'      => 'd7b48c6444974bd997808684b7256215-461564273',
            'client_key' => '3c2cd3f3',
            'os'         => 'android',
            'sig'        => '804c9f930293a918e495cd5898a5f454',
        ],

    ]);
} else {

    // 关注
    $url = 'http://api.ksapisrv.com/rest/n/feed/myfollow?mod=HUAWEI(KNT-AL20)&lon=0&country_code=CN&did=ANDROID_f0c3da7ce59666ce&net=WIFI&app=0&oc=HUAWEI&ud=461564273&c=HUAWEI&sys=ANDROID_7.0&appver=4.56.2.4348&language=zh-cn&lat=0&ver=4.56';
    $response = $client->request('POST', $url, [

        'headers' => [
            'X-REQUESTID'  => '49917476',
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
        ],

        'form_params' => [
            'id'         => '1065',
            'token'      => 'd7b48c6444974bd997808684b7256215-461564273',
            'count'      => '20',
            'client_key' => '3c2cd3f3',
            'type'       => '6',
            'page'       => '1',
            'os'         => 'android',
            'sig'        => '3f4b29ba29da13bfab862680a3c1f66c',
        ],

    ]);
}


//file_put_contents('feed_list.json' ,(string)$response->getBody());
echo ($response->getBody());