<?php

namespace PJ\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class GameType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('label'=>"Société"))
            ->add('console', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                    'class' => 'PJBlogBundle:Console',
                        'choice_label' => 'name',
                        'multiple' => true,
                        'expanded' => true,
                ))
                

            ->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('label'=>"Titre du jeu"))
            ->add('year', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('label'=>"Année de parution"))
            ->add('image',     ImageType::class)
            ->add('content', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, array('label'=>"Contenu",'attr' => array('class' => 'tinymce')))
            ->add('gallery', GalleryType::class)
            ->add('Submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);
                
 
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
}
