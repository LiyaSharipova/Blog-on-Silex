<?php

use Silex\Provider\AssetServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Silex\Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider());

// Security definition.
$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
        // Login URL is open to everybody.
        'login' => array(
            'pattern' => 'user/login',
            'anonymous' => true,
        ),
        'support' => array(
            'pattern' => 'support',
            'anonymous' => true,
        ),
        'signup' => array(
            'pattern' => '/signup',
            'anonymous' => true,
        ),
        // Any other URL requires auth.
        'site' => array(
            'pattern' => '^/.*$',
            'form' => array(
                'login_path' => '/user/login',
//                'check_path' => '/login_check',
                'username_parameter' => 'form[email]',
                'password_parameter' => 'form[password]',
            ),
            'anonymous' => false,
            'logout' => array('logout_path' => '/user/logout'),
            'users' => function () use ($app) {
                return new Model\UserProvider($app['db']);
            },
        ),
    ),
//    'security.access_rules' => array(
//        array('/user/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
//        array('/signup', 'IS_AUTHENTICATED_ANONYMOUSLY'),
//        array('^/.*$', 'ROLE_USER')
//    )
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


require PATH_SRC . '/routes.php';
$app->register(new Silex\Provider\DoctrineServiceProvider());
return $app;
