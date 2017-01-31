<?php

namespace PJ\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserDeleteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->remove('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class)
            ->remove('presentation', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
            ->add('submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NULL
            //'PJ\UserBundle\Entity\User'
        ));
    }
}
