<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 20.06.17
 * Time: 19:53
 */

namespace Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;


class CommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextareaType::class, array('constraints' => array(new Assert\NotBlank(),
            new Assert\Length(array('min' => 2))), 'label' => false, 'attr' => array("class" => "form-control", "rows" => "3")));

    }
}