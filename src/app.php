<?php

use Repo\PostRepo;
use Repo\UserRepo;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Silex\Application();
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new SessionServiceProvider());
//$app->register(new Silex\Provider\SecurityServiceProvider());
//$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
//    'port'		=> '3306',
        'dbname' => 'silex_project_db',
        'user' => 'root',
        'password' => '123456',
        'charset'   => 'utf8',)
));

// Security definition.
$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
        // Login URL is open to everybody.
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true,
//            'check_path' => '/login/login_check',
        ),
        'signup' => array(
            'pattern' => '^/signup',
            'anonymous' => true,
        ),
//        'home' => array(
//            'pattern' => '/',
//            'anonymous' => true,
//        ),
//        'posts' => array(
//            'pattern' => '/post\.*',
//            'anonymous' => true,
//        ),
        // Any other URL requires auth.
//        'site' => array(
////            'pattern' => '/.*$',
//            'pattern' => '.*',
//            'form' => array(
//                'login_path' => '/login',
////                'check_path' => '/login_check',
//                'username_parameter' => 'form[login]',
//                'password_parameter' => 'form[password]',
//            ),
//            'anonymous' => false,
//
//            'logout' => array('logout_path' => '/user/logout'),
//            'users' => function () use ($app) {
//                return new Model\UserProvider($app['db']);
//            },
//        ),

        'add' => array(
            'pattern' => '^.*$',
            'form' => array(
                'login_path' => '/login',
//                'check_path' => 'login_check',
                'username_parameter' => 'form[login]',
                'password_parameter' => 'form[password]',
            ),
            'anonymous' => array(),
            'logout' => array('logout_path' => '/user/logout'),
            'users' => function () use ($app) {
                return new Model\UserProvider($app['db']);
            },
        ),
    ),
    'security.access_rules' => array(
        array('/post/add', 'ROLE_USER'),
        array('/user/profile', 'ROLE_USER'),
    ),

));
// PlainText by default, you can modify the encoder digest as you want.
$app['security.default_encoder'] = function ($app) {
    return new \Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder();
};
//$app->register(new Silex\Provider\TranslationServiceProvider(), array(
//    'translator.domains' => array(),
//));
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));


$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});


$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app['post.repo'] = function (\Silex\Application $app) {
    return new PostRepo($app['db'], $app);
};
$app['user.repo'] = function (\Silex\Application $app) {
    return new UserRepo($app['db'], $app);
};


require PATH_SRC . '/routes.php';
return $app;
