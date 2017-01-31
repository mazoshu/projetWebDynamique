<?php

namespace PJ\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class UserInscrType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('presentation', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PJ\UserBundle\Entity\User'
            //NULL
            //'PJ\UserBundle\Entity\User'
        ));
    }
     public function getName()
    {
        return 'myapp_user_registration';
    }
}
