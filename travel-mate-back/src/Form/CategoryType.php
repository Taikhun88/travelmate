<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de la catégorie à créer'
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
            //->add('createdAt')
            //->add('updatedAt')
            //->add('event')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
