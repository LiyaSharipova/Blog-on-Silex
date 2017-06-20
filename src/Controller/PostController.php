<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 16.06.17
 * Time: 18:36
 */

namespace Controller;


use Form\PostForm;
use Model\Post;
use Model\UserProvider;
use Repo\Interfaces\IPostRepo;
use Repo\Interfaces\IUserRepo;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class PostController implements ControllerProviderInterface
{
    protected $postRepo;
    protected $userRepo;

    /**
     * PostController constructor.
     * @param $postRepo
     */
    public function __construct(IPostRepo $postRepo, IUserRepo $userRepo)
    {
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
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


        $postController = $app['controllers_factory'];
        $postController->match("/add", array($this, "add"))->bind('addPost');
        $postController->match("/all", array($this, "getAllPosts"))->bind('all');

        return $postController;
    }

    function add(Application $app, Request $request)
    {

        $form = $app['form.factory']->create(PostForm::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
//            $user = $app['security.token_storage']->getToken()->getUser();
            $data = $form->getData();
            $user = $this->userRepo->getUser();
            $post = new Post($user, $data['title'], $data['content']);
            $this->postRepo->insert($post, $user->getId());

            return $app->redirect($app['url_generator']->generate('all'));
//            return $app['twig']->render('test.html.twig', array("user" => $user->getId()));

        }
        return $app['twig']->render('addPost.html.twig', array("form" => $form->createView()));

    }

    function getAllPosts(Application $app)
    {
        return $app['twig']->render('allPosts.html.twig', array());

    }
}