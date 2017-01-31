<?php

namespace PJ\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserModType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->remove('email')
                ->remove('presentation')
                ->remove('submit')
                ->add('roles', ChoiceType::class, array(
                    'multiple'=>true,
                  'choices'  => array(
                  'User' => 'ROLE_USER',
                  'Moderateur' => 'ROLE_MODERATOR',
                  'Administrateur' => 'ROLE_ADMIN',
                  ))) 
                
                ->add('sumbit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);
    }

    public function getParent() {
        return UserType::class;
    }

}
