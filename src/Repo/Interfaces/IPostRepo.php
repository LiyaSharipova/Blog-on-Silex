<?php

/**
 * Created by PhpStorm.
 * User: liya
 * Date: 18.06.17
 * Time: 12:58
 */

namespace Repo\Interfaces;
use Model\Post;

interface IPostRepo
{
    function insert(Post $post);
    function getPosts();

}