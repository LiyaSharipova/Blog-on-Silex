<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 17.06.17
 * Time: 22:15
 */

namespace Repo;


use Model\Post;
use Repo\Interfaces\IPostRepo;

class PostRepo extends BaseRepo implements IPostRepo
{
    public function findAll(){
        return "All posts here";
    }

    function insert(Post $post)
    {
        // TODO: Implement insert() method.
        $this->db->insert('post', array(
            'user_id' => $post->getAuthor()->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
        ));
    }

    function getPosts()
    {
        // TODO: Implement getPosts() method.
        return "ALL POSTS))))))";
    }
}