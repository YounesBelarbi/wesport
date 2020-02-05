<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventOrganisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventBody')
            // ->add('author')
            ->add('sportConcerned', EntityType::class, [
                'class' => Sport::class,
            ])
            ->add('title')
            ->add('location')
            ->add('eventDate')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('participatingUserList')
            // ->add('eventOrganizer')
            ->add('send', SubmitType::class, [
                'label' => 'modifier'
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
