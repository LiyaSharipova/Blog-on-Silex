<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 24.05.17
 * Time: 0:27
 */

namespace Controller {

    use Silex\Api\ControllerProviderInterface;
    use Silex\Application;
    use Silex\ControllerCollection;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\Extension\Core\Type\FormType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Validator\Constraints as Assert;

    class IndexController implements ControllerProviderInterface
    {

        /**
         * Returns routes to connect to the given application.
         *
         * @param Application $app An Application instance
         *
         * @return ControllerCollection A ControllerCollection instance
         */
        public function connect(Application $app)
        {
            // TODO: Implement connect() method.
            $indexController = $app['controllers_factory'];
            $indexController->get("/", array($this, 'index'))->bind('default');
            $indexController->match("/signup", array($this, 'signup'))->bind('signup');


            return $indexController;
        }


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

                // do something with the data

                // redirect somewhere
                return $app->redirect('...');
            }

            // display the form
            return $app['twig']->render('signup.html.twig', array('form' => $form->createView()));
//            return $app['twig']->render('signup.html.twig', array());

        }
    }
}

