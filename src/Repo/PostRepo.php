<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 17.06.17
 * Time: 22:15
 */

namespace Repo;


use Model\Post;
use Model\User;
use Repo\Interfaces\IPostRepo;
use Repo\Interfaces\IUserRepo;
use Silex\Application;

class PostRepo extends BaseRepo implements IPostRepo
{
    protected $userRepo;

    /**
     * PostRepo constructor.
     * @param $userRepo
     */
    public function __construct($db, Application $app, IUserRepo $userRepo)
    {
        parent::__construct($db, $app);
        $this->userRepo = $userRepo;

    }

    /**
     * PostRepo constructor.
     * @param $userRepo
     */


    function insert(Post $post)
    {
        $this->db->insert('post', array(
            'user_id' => $post->getAuthor()->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
        ));
    }

    function getPosts()
    {
        // TODO: Implement getPosts() method.
        $posts = array();
        $stmt = $this->db->executeQuery('SELECT *  FROM post  ORDER BY ts DESC');
        $posts_res = $stmt->fetchAll();
        foreach ($posts_res as $post_res) {
            $user = $this->userRepo->getById($post_res['user_id']);
            $content = $post_res['content'];
            $pos = strpos($content, "\n", 2500);
            $content = substr($content, 0, $pos) . "...";
            $post = new Post($user, $post_res['title'], $content);
            $post->setDate($post_res['ts']);
            $post->setId($post_res['id']);
            array_push($posts, $post);
        }
        return $posts;
    }

    function getPostCount()
    {
        $count = $this->db->executeQuery("SELECT *  FROM post ")->rowCount();
        return $count;
    }

    function getById($id)
    {
        $stmt = $this->db->executeQuery('SELECT * FROM post WHERE id = ?', array(strtolower($id)));
        $post_res = $stmt->fetch();
        $user = $this->userRepo->getById($post_res['user_id']);
        $post = new Post($user, $post_res['title'], $post_res['content']);
        $post->setDate($post_res['ts']);

        return $post;
    }

    function getPostByUserCount($user_id)
    {
        $posts = array();
        $stmt = $this->db->executeQuery('SELECT * FROM post WHERE user_id = ?', array(strtolower($user_id)));
        $posts_res = $stmt->fetchAll();
        foreach ($posts_res as $post_res) {
            $user = $this->userRepo->getById($post_res['user_id']);
            $content = $post_res['content'];
            $pos = strpos($content, "\n", 2500);
            $content = substr($content, 0, $pos) . "...";
            $post = new Post($user, $post_res['title'], $content);
            $post->setDate($post_res['ts']);
            $post->setId($post_res['id']);
            array_push($posts, $post);
        }
        return $posts;
    }
}