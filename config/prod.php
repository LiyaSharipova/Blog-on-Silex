<?php

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');
$app['twig.form.templates'] = array('bootstrap_3_horizontal_layout.html.twig');

// Doctrine (db).
//$app['db.options'] = array(
//    'driver'	=> 'pdo_mysql',
//    'host'		=> 'localhost',
////    'port'		=> '3306',
//    'dbname'	=> 'silex_project_db',
//    'user'		=> 'root',
//    'password'	=> '123456',
//);