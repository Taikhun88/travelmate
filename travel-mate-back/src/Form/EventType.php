<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'widget' => 'single_text'
            ])
            ->add('status', ChoiceType::class,[
                'placeholder' => 'A déterminer',
                'label' => 'Statut de l\'événement',
                'choices' => [
                'A venir' => 'A venir',
                'En cours' => 'En cours', 
                'Terminé' => 'Terminé',
            ]])
            //->add('createdAt')
            //->add('updatedAt')
            //->add('users')
            //->add('categories')
            ->add('city', EntityType::class,[
                'class' => Event::class,
                'choices' 

            ])
            //->add('creator')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
