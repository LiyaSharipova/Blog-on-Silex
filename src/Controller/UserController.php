<?php

namespace Controller {

    use Silex\Api\ControllerProviderInterface;
    use Silex\Application;
    use Silex\ControllerCollection;

    class UserController implements ControllerProviderInterface
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
            $userController->get("/profile", array($this, 'profile'))->bind('profile');
            return $userController;
        }


        function profile( Application $app )
        {
            return $app['twig']->render('index.html.twig', array());

        }
    }
}
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 22.05.17
 * Time: 19:12
 */
