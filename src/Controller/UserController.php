<?php

namespace Controller {

    use Silex\Application;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
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

        function login(Application $app, Request $request)
        {
            $form = $app['form.factory']->createBuilder(FormType::class)
                ->add('email', EmailType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Email())
                ))
                ->add('password', PasswordType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 6)))
                ))
                ->add('submit', SubmitType::class, [
                    'label' => 'Login',
                ])
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();

                // do something with the data

                // redirect somewhere
                return $app->redirect('/profile');
            }
//            $token = $app['security.token_storage']->getToken();
//            if (null !== $token) {
//                $user = $token->getUser();
//            }
            return $app['twig']->render('login.html.twig', array('form' => $form->createView(), 'error' => $app['security.last_error']($request),));
        }




    }
}
