<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 22.05.17
 * Time: 22:10
 */
$app->mount( '/user', new Controller\UserController() );
$app->mount( '/', new Controller\IndexController() );
