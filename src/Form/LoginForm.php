<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 20.06.17
 * Time: 0:05
 */

namespace Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', TextType::class, array(
            'constraints' => array(new Assert\NotBlank())
        ));
        $builder->add('password', PasswordType::class, array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 6)))
        ));
        $builder->add('submit', SubmitType::class, [
            'label' => 'Login', 'attr' => ['class' => 'btn btn-primary']
        ]);
    }
}