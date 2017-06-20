<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 19.06.17
 * Time: 0:13
 */

namespace Repo\Interfaces;


use Model\User;
use Silex\Application;

interface IUserRepo
{
    function insert(User $user);
    function getUser();
    function getByUsername($username);

}