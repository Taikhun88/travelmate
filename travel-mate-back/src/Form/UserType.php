<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles',
            ChoiceType::class,
            [
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_EDITOR' => 'ROLE_EDITOR',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                // Affichage des éléments sous forme de cases à cocher
                'expanded' => true
            ])
            ->add('password')
            ->add('lastname')
            ->add('firstname')
            ->add('nickname')
            ->add('image')
            ->add('age')
            ->add('nationality')
            ->add('language')
            //->add('createdAt')
            //->add('updatedAt')
            ->add('events')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
