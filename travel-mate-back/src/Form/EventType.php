<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Event;
use App\Repository\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de l\'événement',                 
            ])
            //->add('image')
            ->add('content', TextareaType::class, [
                'label' => 'Description',                
            ])
            //->add('resume')
            ->add('participant', IntegerType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [new Positive()],
                'attr' => [
                'min' => 1,
                'max' => 500
            ]])
            ->add('startAt', DateTimeType::class,[
                'label' => 'Commence le',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'empty_data' => '',
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('city', EntityType::class, [
                'label' => 'Ville',
                'class' => City::class,
                'query_builder' => function(CityRepository $cityRepository) {
                    return $cityRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                }
            ])
            // ->add('creator')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
