<?php
/**
 * Created by PhpStorm.
 * User: hezhang
 * Date: 17/5/17
 * Time: 下午2:09
 */

require_once 'vendor/autoload.php';

class_alias('\RedBeanPHP\R','\R');

R::setup( 'mysql:host=localhost;dbname=alone', 'root', 'westos' );
R::setAutoResolve( TRUE );
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});

$web = R::xdispense('web_stuff');

//$web->url = 'https://toutiao.io';
//$web->description = '开发者头条';

$web->url = 'http://www.infoq.com';
$web->description = 'InfoQ';

$id = R::store( $web );

$web = R::load( 'web_stuff', $id );

var_dump($web->description);
R::close();
