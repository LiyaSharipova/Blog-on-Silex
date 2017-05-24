<?php

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

// Doctrine (db).
$app['db.options'] = array(
    'driver'	=> 'pdo_mysql',
    'host'		=> 'localhost',
    'dbname'	=> 'silex_project_db',
    'user'		=> 'root',
    'password'	=> 'root',
);