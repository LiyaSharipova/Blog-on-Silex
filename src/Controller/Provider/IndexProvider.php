<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 24.05.17
 * Time: 13:04
 */

namespace Controller\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class IndexProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $indexController = $app['controllers_factory'];
        $indexController->get("/index", "Controller\\IndexController::index")->bind('default');
        $indexController->match("/signup", "Controller\\IndexController::signup")->bind('signup');
        $indexController->match("/support", "Controller\\IndexController::support")->bind('support');


        return $indexController;
    }
}