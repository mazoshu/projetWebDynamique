<?php

namespace PJ\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class GameSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('author', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->remove('content' ,  \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
            ->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('required' => false))
            ->add('console', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('required' => false))
            ->remove('gallery', GalleryType::class)
            ->add('year', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('required' => false))
            ->add('Rechercher',      SubmitType::class)->setMethod('get');
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PJ\BlogBundle\Entity\Game'
        ));
    }
    public function getName()
    {
        return 'annonce_ok';
    }
}
