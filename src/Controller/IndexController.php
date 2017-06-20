<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 24.05.17
 * Time: 13:04
 */

namespace Controller;


use Form\LoginForm;
use Form\SignupForm;
use Model\User;
use Repo\Interfaces\IUserRepo;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class IndexController implements ControllerProviderInterface
{
    protected $userRepo;

    /**
     * IndexController constructor.
     * @param $userRepo
     */
    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $indexController = $app['controllers_factory'];
        $indexController->get("/", array($this, "index"))->bind('default');
        $indexController->match("/login", array($this, "login"))->bind('login');
        $indexController->match("/signup", array($this, "signup"))->bind('signup');


        return $indexController;
    }

    function index(Application $app)
    {
        return $app->redirect($app['url_generator']->generate('all'));

    }

    function signup(Application $app, Request $request)
    {
        $form = $app['form.factory']->create(SignupForm::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $user = new User($data['login'], $data['password']);
            $user->setEmail($data['email']);
            $this->userRepo->insert($user);

            return $app->redirect($app['url_generator']->generate('login'));

        }

        // display the form
        return $app['twig']->render('signup.html.twig', array('form' => $form->createView()));

    }

    function login(Application $app, Request $request)
    {
        $form = $app['form.factory']->createBuilder(FormType::class)
            ->add('login', TextType::class, array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('password', PasswordType::class, array(
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 6)))
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Login',
            ])
            ->getForm();

//        $form = $app['form.factory']->create(LoginForm::class);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            // do something with the data

            return $app->redirect('/profile');
        }

        return $app['twig']->render('login.html.twig', array('form' => $form->createView(), 'error' => $app['security.last_error']($request),));
    }


}