<?php

// curl
class Client
{
	protect $config = [];
	protect $instance = null;

	public function __construct($method, array $config)
	{
		if( !empty($config) ) {
			throw new Exception("Error Parameter", -1);
			
			// TODO
		} else {
			$config = [
				'ch'  => 100,
				'url' => 'www.baidu.com', // TODO
				'timeout' => 30,
			];
		}
		$this->config = $config;
		$chArr = [];
		for ($i=0; $i<$config['ch']; $i++) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $config['url']);
				curl_setopt($ch, CURLOPT_TIMEOUT, $config['timeout']);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_NOSIGNAL, true);
				$chArr[$i] = $ch;
		}
		// TODO


	}
	/*
        $chArr=[];
		$post = array("name"=>"hezhang","phone"=>"15810741239","school"=>"北大","dream"=>"无");
		$url = "http://localhost:8080/submit";
		// $url = 'http://www.test2.com/';
		// $url = 'cuotiben02.xueba100.com/submit';
		// $url = 'wx-dev.xuebadev.com/submit';
        for($i=0;$i<100;$i++){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_NOSIGNAL, true);
				$chArr[$i] = $ch;
        }
		$mh = curl_multi_init(); //1
		
       foreach($chArr as $k => $ch){
		   curl_multi_add_handle($mh,$ch); //2	
	   }
       $running = null; 

       do{
		   curl_multi_exec($mh,$running); //3
		   
        }while($running > 0); //4

        foreach($chArr as $k => $ch){ 

              $result[$k]= curl_multi_getcontent($ch); //5

              curl_multi_remove_handle($mh,$ch);//6

        }

        curl_multi_close($mh); //7
		foreach($result as $res){
			var_dump($res);
			$array = json_decode($res,true);
			var_dump($array);
		}
	*/
}