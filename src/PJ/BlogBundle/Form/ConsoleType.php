<?php

namespace PJ\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsoleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pc', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('playstation', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('xbox', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('nintendo', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PJ\BlogBundle\Entity\Console'
        ));
        
    }
}
