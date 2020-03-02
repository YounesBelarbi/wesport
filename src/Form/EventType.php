<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventBody',null, [
                'row_attr' => ['class' => 'col-md-12'],
                'label' => 'Texte déscriptif de l\'événement',
            ])
            ->add('sportConcerned', EntityType::class, [
                'class' => Sport::class,
                'row_attr' => ['class' => 'col-md-4'],
                'label' => 'Sport',
            
            ])
            ->add('title',null, [
                'row_attr' => ['class' => 'col-md-12'],
                'label' => 'Titre de l\événement',
            ])
            ->add('location',null, [
                'row_attr' => ['class' => 'col-md-4'],
                'label' => 'Lieu de l\'événement',
            ])
            ->add('eventDate',DateType::class, [
                'row_attr' => ['class' => 'col-md-4'],
                'label' => 'Date de l\événement',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
        
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                'label' => 'Enregistrer l\'événement',
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
