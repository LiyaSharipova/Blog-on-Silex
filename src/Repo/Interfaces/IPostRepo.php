<?php

/**
 * Created by PhpStorm.
 * User: liya
 * Date: 18.06.17
 * Time: 12:58
 */

namespace Repo\Interfaces;
use Model\Post;
use Model\User;

interface IPostRepo
{
    function insert(Post $post);
    function getPosts();
    function getPostCount();
    function getPostByUserCount($user_id);
    function getById($id);

}