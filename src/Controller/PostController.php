<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 16.06.17
 * Time: 18:35
 */

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PostController
{
    function add(Application $app, Request $request)
    {
        $post = $request->get('postBody');
        return $app['twig']->render('addPost.html.twig', array('post'=> $post));

    }
}