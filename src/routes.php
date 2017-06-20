<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 22.05.17
 * Time: 22:10
 */
$app->mount( '/user', new Controller\Provider\UserControllerProvider() );
$app->mount( '/', new Controller\IndexController($app['user.repo']) );
$app->mount( '/post', new Controller\PostController($app['post.repo'], $app['user.repo']) );
