<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 16.06.17
 * Time: 18:36
 */

namespace Controller;


use Dto\CommentNodeDto;
use ErrorException;
use Form\CommentForm;
use Form\PostForm;
use Model\Comment;
use Model\Post;
use Repo\Interfaces\ICommentRepo;
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
    protected $commentRepo;

    /**
     * PostController constructor.
     * @param $postRepo
     */
    public function __construct(IPostRepo $postRepo, IUserRepo $userRepo, ICommentRepo $commentRepo)
    {
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
        $this->commentRepo = $commentRepo;
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
        $postController->match("/addComment", array($this, "add"))->bind('addComment');
        $postController->get("/all", array($this, "getAllPosts"))->bind('all');
        $postController->match("/{id}", array($this, "getPostPage"))->bind('postPage');

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

    function getAllPosts(Application $app, Request $request)
    {

        $posts = $this->postRepo->getPosts();

        return $app['twig']->render('allPostsPage.html.twig', array("posts" => $posts, "count" => count($posts),));

    }

    function getPostPage(Application $app, $id, Request $request)
    {
        $post = $this->postRepo->getById($id);
        $form = $app['form.factory']->create(CommentForm::class);
        $form->handleRequest($request);
        $comments = $this->commentRepo->getComments($id);

        $commentsTree = $this->buildCommentsTree($comments);

        if ($form->isValid()) {
            $data = $form->getData();
            $user = $this->userRepo->getUser();
            $comment = new Comment($user, $id, $data['content']);
            $this->commentRepo->insert($comment);
//            $user = $app['security.token_storage']->getToken()->getUser();
//            $user->getUsername();

        }

        return $app['twig']->render('postPage.html.twig', array("post" => $post, "form" => $form->createView(), "comments" => $commentsTree));
    }

    function buildCommentsTree(array $comments): array
    {
        $commentsTree = array();
        uasort($comments, function (Comment $comment1, Comment $comment2) {
            if ($comment1->getTs() == $comment2->getTs()) {
                return 0;
            }
            return ($comment1->getTs() < $comment2->getTs()) ? -1 : 1;
        });

        $childsOfEachComment = $this->buildChildsOfEachComment($comments);

        foreach ($comments as $comment) {
            if ($comment->getParentId() == null) {
                $inheritanceLevel = 0;
                $commentNode = $this->createCommentNode($comment, $childsOfEachComment, ++$inheritanceLevel);
                $commentNode->setInheritanceLevel($inheritanceLevel);
                array_push($commentsTree, $commentNode);
                $inheritanceLevel = 0;
            }
        }
        return $commentsTree;
    }

    public function createCommentNode(Comment $comment, array $childsOfEachComment, $inheritanceLevel): CommentNodeDto
    {
        $commentNode = new CommentNodeDto();
        $commentNode->setContent($comment->getContent());


        $commentNode->setInheritanceLevel($inheritanceLevel);

        $user = $this->userRepo->getById($comment->getUser()->getId());
        $commentNode->setUser($user);

        $date = date('M j Y g:i A', strtotime($comment->getTs()));;
        $commentNode->setDate($date);

        if ($this->hasComments($comment, $childsOfEachComment))
            foreach ($childsOfEachComment[$comment->getId()] as $childComment) {
                $childCommentNode = $this->createCommentNode($childComment, $childsOfEachComment, ++$inheritanceLevel);
                $commentNode->addChild($childCommentNode);
            }

        if ($commentNode->getChilds() !== null && sizeof($commentNode->getChilds()) != 0) {
            uasort($commentNode->getChilds(), function (CommentNodeDto $comment1, CommentNodeDto $comment2) {
                if ($comment1->getDate() == $comment2->getDate()) {
                    return 0;
                }
                return ($comment1->getDate() < $comment2->getDate()) ? -1 : 1;
            });
        }
        return $commentNode;

    }

    private function hasComments(Comment $comment, array $childsOfEachComment): bool
    {
        try {
            $childsOfEachComment[$comment->getId()];
        } catch (ErrorException $e) {
            return false;
        }

        if ($childsOfEachComment[$comment->getId()] == null)
            return false;
        else return true;

    }

    private function buildChildsOfEachComment(array $comments): array
    {
        $mapChilds = array();
        foreach ($comments as $comment) {
            if ($comment->getParentId() != null) {
                if ($mapChilds[$comment->getParentId()] == null)
                    $mapChilds[$comment->getParentId()] = array();
                array_push($mapChilds[$comment->getParentId()], $comment);
            }
        }
        return $mapChilds;
    }


}