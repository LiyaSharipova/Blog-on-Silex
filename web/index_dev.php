<?php

use Symfony\Component\Debug\Debug;
define( 'PATH_ROOT', dirname( __DIR__ ) );
define( 'PATH_CACHE', PATH_ROOT . '/cache' );
define( 'PATH_LOCALES', PATH_ROOT . '/locales' );
define( 'PATH_LOG', PATH_ROOT . '/log' );
define( 'PATH_PUBLIC', PATH_ROOT . '/public' );
define( 'PATH_SRC', PATH_ROOT . '/src' );
define( 'PATH_VENDOR', PATH_ROOT . '/vendor' );
define( 'PATH_VIEWS', PATH_SRC . '/views' );

ini_set('display_errors', 1);
error_reporting(-1);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once __DIR__.'/../vendor/autoload.php';

Debug::enable();

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/dev.php';
require __DIR__.'/../src/controllers.php';
$app->run();
