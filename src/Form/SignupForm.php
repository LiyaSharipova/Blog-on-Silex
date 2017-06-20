<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 19.06.17
 * Time: 21:50
 */

namespace Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;


class SignupForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', TextType::class, array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
        ))
            ->add('email', EmailType::class, array(
                'constraints' => array(new Assert\NotBlank(), new Assert\Email())
            ))
            ->add('password', PasswordType::class, array(
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 6)))
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Sign Up', 'attr'=> ['class'=>'btn btn-primary'],
            ]);
    }
}