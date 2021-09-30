<?php

namespace App\Form;

use App\Entity\User;
use DateTimeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

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
            ->add('age', IntegerType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [new Positive()],
                'attr' => [
                'min' => 18,
                'max' => 100
            ]])
            ->add('nationality', ChoiceType::class, [
                'placeholder' => 'Sélectionnez le pays de naissance',
                'label' => 'Nationalité',
                'choices' => [ 
                'Algérie' => 'DZ',
                'Argentina' => 'AR',
                'Australia' => 'AU',
                'Belgium' => 'BE',
                'Canada' => 'CA',
                'China' => 'CN',
                'France' => 'FR',
                'Croatia' => 'HR',
                'Germany' => 'DE',                
                'HK' => 'Hong Kong',               
                'IN' => 'India',                
                'IT' => 'Italy',
                'JP' => 'Japan',
                'KP' => 'Korea, Democratic People\'s Republic of',                
                'Mexico' => 'MX',             
                'Qatar' => 'QA',              
                'Saudi Arabia' => 'SA',
                'Senegal' => 'SN',             
                'Singapore' => 'SG',
                'Spain' => 'ES',
                'Sweden' => 'SE',
                'Switzerland' => 'CH',
                'Taiwan' => 'TW',
                'Turkey' => 'TR',            
                'United Arab Emirat' => 'AE',
                'United Kingdom' => 'GB',             
            ]])
            ->add('language', ChoiceType::class, [
                'placeholder' => 'Sélectionnez vos langues parlées',
                'label' => 'Langues parlées',
                'choices' => [ 
                    'Afrikaans' => 'AF',
                    'Arabic' => 'AR',
                    'Chinese' => 'ZH',
                    'Croatian' => 'HR',
                    'Czech' => 'CZ',
                    'Dutch' => 'NL',
                    'English' => 'EN',
                    'French' => 'FR',
                    'German' => 'DE',
                    'Hindi' => 'HI',
                    'Hungarian' => 'HU',
                    'Indonesian' => 'ID',
                    'Italian' => 'IT',
                    'Japanese' => 'JA',
                    'Khmer' => 'KM',
                    'Korean' => 'KO',
                    'Norwegian' => 'NO',
                    'Polish' => 'PL',
                    'Portuguese' => 'PT',
                    'Punjabi' => 'PA',
                    'Russian' => 'RU',
                    'Spanish' => 'ES',
                    'Thai' => 'TH',
                    'Turkish' => 'TR',             
            ]])
            //->add('createdAt')
            //->add('updatedAt')
            //->add('events')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}