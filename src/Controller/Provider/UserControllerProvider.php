<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 24.05.17
 * Time: 14:30
 */

namespace Controller\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class UserControllerProvider implements ControllerProviderInterface
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
        // TODO: Implement connect() method.
        $userController = $app['controllers_factory'];
        $userController->get("/profile", "Controller\\UserController::profile")->bind('profile');

        return $userController;
    }
}