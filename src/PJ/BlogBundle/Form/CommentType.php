<?php

namespace PJ\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('date',   \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class)
            ->add('content', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
            ->add('Submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PJ\BlogBundle\Entity\Comment'
        ));
    }
}
