<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
=======
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
>>>>>>> b21af327c08f52a6afbb9bc333d34f7aceaf49dd
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, array(
                'attr' => array(
                    'placeholder' => 'votrecontact@email.com'
                )
            ))
            ->add('roles',
            ChoiceType::class,
            [
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    //'ROLE_EDITOR' => 'ROLE_EDITOR',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                // Affichage des éléments sous forme de cases à cocher
                'expanded' => true
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
            'placeholder' => 'Minimum 9 caractères, 1 majuscule, 1 caracère spécial et 1 chiffre'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 9,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
<<<<<<< HEAD
            ->add('lastname')
            ->add('firstname')
            ->add('nickname')
            ->add('image')
=======
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',                 
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom(s)'
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Pseudo'
            ])
            ->add('image', FileType::class, [
                'label' => 'Téléchargez votre image',

                // Indicates if this field is linked, related to a property
                'mapped' => false,

                // This option is helpful in case of editing. image to upload will become optionnal or not basing on boolean value chosen
                'required' => false,
  
                // Define all the constraints, limits related to the file to be upload thanks to options of File object
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Sélectionnez une image au format .png ou .jpeg',
                    ])
                ],
            ] )
>>>>>>> b21af327c08f52a6afbb9bc333d34f7aceaf49dd
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