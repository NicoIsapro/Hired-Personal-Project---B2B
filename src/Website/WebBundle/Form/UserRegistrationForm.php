<?php

namespace Website\WebBundle\Form;

use Website\WebBundle\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod( "POST" )
            ->add('company', TextType::class, array('attr' => array('placeholder' => 'Fill your company name',)))
            ->add('surname', TextType::class, array('attr' => array('placeholder' => 'ex: John',)))
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'ex: Fitz',)))
            ->add('username', TextType::class, array('attr' => array('placeholder' => 'ex: john.fritz',)))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Your professional email',)))
            ->add('password', PasswordType::class, array('attr' => array('placeholder' => 'A secure password',)))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class
        ]);
    }
}
