<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 20.06.17
 * Time: 20:43
 */

namespace Repo\Interfaces;


use Model\Comment;

interface ICommentRepo
{
    function insert(Comment $comment);
    function getComments($post_id);
//    function getResposes(Comment $comment);
}