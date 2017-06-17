<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 16.06.17
 * Time: 18:36
 */

namespace Controller\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class PostProvider implements ControllerProviderInterface
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
        $postController = $app['controllers_factory'];
        $postController->match("/add", "Controller\\PostController::add")->bind('addPost');

        return $postController;
    }
}