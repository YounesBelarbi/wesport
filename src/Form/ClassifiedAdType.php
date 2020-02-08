<?php

namespace App\Form;

use App\Entity\ClassifiedAd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassifiedAdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classifiedAdBody')
            ->add('title')
            // ->add('author')
            ->add('sportConcerned')
            ->add('objectForSale')
            ->add('send', SubmitType::class, [
                'label' => 'modifier'
            ])
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('seller')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClassifiedAd::class,
        ]);
    }
}
