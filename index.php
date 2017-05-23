<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;



$i = 10;
while ($i--) {

	// 1. parse
	$client = new Client();
//	$url = 'https://toutiao.io/k/e4vch8';
//    $response = $client->request('GET', $url, [
//        'allow_redirects' => false
//    ]);
//    $statusCode = $response->getStatusCode();
//    $body = (string) $response->getBody();
//    $header = $response->getHeaders();
//    var_dump($statusCode);
//    echo "\r\n";
//    var_dump($body);
//    echo "\r\n";
//    var_dump($header);
//
//    die();
	$origal_url = 'https://toutiao.io/shares/'.$i.'/url';
	try{
		$response = $client->request('GET', $origal_url, [
    		'allow_redirects' => false
		]);		
	}catch(\Exception $e){
		var_dump($e->getMessage());
		echo "\r\n";
	}

	$statusCode = $response->getStatusCode();
	if( 302 != $statusCode ) {
		echo 'Failed at pull '. $origal_url,"\r\n";
		continue;
	}

	$location = $response->getHeader('Location');
	if( empty($location) ) {
		echo 'Failed as Location ',"\r\n";
		content;
	}
	$location = current($location);

// var_dump($location);die();
	// 2. jump
	// $client = new Client();
	$jump_url = $location;
	try{
		$response = $client->request('GET', $jump_url, [
	    	'allow_redirects' => false
		]);
	}catch(\Exception $e){
		var_dump($e->getMessage());
		echo "\r\n";
	}
	

	$statusCode = $response->getStatusCode();
	if( 302 != $statusCode ) {
		echo 'Failed at pull '. $origal_url,"\r\n";
		continue;
	}

	$location = $response->getHeader('Location');
	if( empty($location) ) {
		echo 'Failed as Location ',"\r\n";
		continue;
	}

	$location = current($location);

	$info_url = 'https://api.toutiao.io/v2/shares/'.$i.'?app_key=u1ntgkc99st7sdhqjo5p&timestamp=1494923916&signature=3890577d3e05a24a95edae5f970a302f64ceb657';
	try{
		$response = $client->request('GET', $info_url, [
			'headers' => [
				// 'X-Toutiao-Token' => '7d7c42cd-607b-4fab-b669-c6d047d0be69', 
			],
	    	'allow_redirects' => false
		]);
	}catch(\Exception $e){
		var_dump($e->getMessage());
		echo "\r\n";
		continue;
	}

	$body = (string) $response->getBody();
	echo $body;
	echo $location,"\r\n";

}

// $response = $client->get('https://toutiao.io/shares/760072/url');
// $response = $client->request('GET', 'https://toutiao.io/shares/760072/url', [
//     'allow_redirects' => false
// ]);

// foreach ($response->getHeaders() as $name => $values) {
//     echo $name . ': ' . implode(', ', $values) . "\r\n";
// }

// $body = (string) $response->getBody();
// $statusCode = $response->getStatusCode();
// var_dump($statusCode);
// // $content = $body-getContents();
// var_dump($body);