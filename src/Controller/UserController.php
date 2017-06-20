<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 24.05.17
 * Time: 14:30
 */

namespace Controller;


use Repo\Interfaces\IPostRepo;
use Repo\Interfaces\IUserRepo;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class UserController implements ControllerProviderInterface
{

    protected $userRepo;
    protected $postRepo;

    /**
     * UserController constructor.
     * @param $userRepo
     */
    public function __construct(IUserRepo $userRepo, IPostRepo $postRepo)
    {
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
    }


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
        $userController->get("/{id}", array($this, "profile"))->bind('profile');

        return $userController;
    }

    function profile(Application $app, $id, Request $request)
    {
        $user = $this->userRepo->getById($id);
        $posts =$this->postRepo->getPostByUserCount($id);

        return $app['twig']->render('profile.html.twig', array("user" => $user, "posts" => $posts, "count" => count($posts) ,));

    }
}