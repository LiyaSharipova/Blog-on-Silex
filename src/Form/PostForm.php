<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 19.06.17
 * Time: 21:33
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;


class PostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array('constraints' => array(new Assert\NotBlank())))
            ->add('content', TextareaType::class, array('constraints' => array(new Assert\NotBlank(),
                new Assert\Length(array('min' => 30))), 'attr' => array("class" => "mytextarea")))
            ->add('submit', SubmitType::class,
                array('label' => 'Add', 'attr' => array('class' => 'btn btn-primary')));
//            ->add('submit', SubmitType::class, [
//                'label' => 'Sign Up', 'attr' => ['class' => 'btn btn-primary'],
//            ]);
    }


}