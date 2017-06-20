<?php

namespace Controller {

    use Silex\Application;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\FormType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Validator\Constraints as Assert;


    class UserController
    {


        function profile(Application $app)
        {
            $token = $app['security.token_storage']->getToken();
            if (null !== $token) {
                $user = $token->getUser();
            }
            return $app['twig']->render('profile.html.twig', array('user' => $user));

        }





    }
}
