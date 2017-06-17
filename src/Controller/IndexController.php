<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 24.05.17
 * Time: 0:27
 */

namespace Controller {

    use Silex\Application;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\Extension\Core\Type\FormType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Validator\Constraints as Assert;

    class IndexController
    {


        function index(Application $app)
        {
            return $app['twig']->render('index.html.twig', array());

        }

        function signup(Application $app, Request $request)
        {


            $form = $app['form.factory']->createBuilder(FormType::class)
                ->add('login', TextType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
                ))
                ->add('email', EmailType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Email())
                ))
                ->add('password', PasswordType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 6)))
                ))
                ->add('submit', SubmitType::class, [
                    'label' => 'Sign Up',
                ])
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();
//                $password = $app['security.encoder.digest']->encodePassword($data['password'], '');
                $role = 'ROLE_USER';
                $app['db']->insert('user', array(
                    'login' => $data['login'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'roles' => $role
                ));
                // do something with the data

                // redirect somewhere
                return $app->redirect('user/login');
            }

            // display the form
            return $app['twig']->render('signup.html.twig', array('form' => $form->createView()));
//            return $app['twig']->render('signup.html.twig', array());

        }


    }
}

