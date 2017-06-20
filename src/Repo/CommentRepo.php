<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 20.06.17
 * Time: 20:44
 */

namespace Repo;


use Model\Comment;
use Repo\Interfaces\ICommentRepo;
use Repo\Interfaces\IUserRepo;
use Silex\Application;

class CommentRepo extends BaseRepo implements ICommentRepo
{
    public function __construct($db, Application $app, IUserRepo $userRepo)
    {
        parent::__construct($db, $app);
        $this->userRepo = $userRepo;

    }


    function insert(Comment $comment)
    {

        $this->db->insert('comment', array(
            'user_id' => $comment->getUser()->getId(),
            'post_id' => $comment->getPostId(),
            'content' => $comment->getContent()
        ));
    }

    function getComments($post_id)
    {
        $comments = array();
        $stmt = $this->db->executeQuery('SELECT * FROM comment WHERE post_id = ?', array(strtolower($post_id)));
        $comments_res = $stmt->fetchAll();
        foreach ($comments_res as $comment_res) {
            $user = $this->userRepo->getById($comment_res['user_id']);
            $content = $comment_res['content'];
            $comment = new Comment($user, $post_id, $content);
            $comment->setDate($comment_res['ts']);
            $comment->setId($comment_res['id']);
            array_push($comments, $comment);
        }
        return $comments;
    }
}