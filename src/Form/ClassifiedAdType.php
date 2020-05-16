<?php

namespace App\Form;

use App\Entity\ClassifiedAd;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassifiedAdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classifiedAdBody', null, [
                'row_attr' => ['class' => 'col-md-12'],
                'label' => 'Texte de votre annnonce',
            ])
            ->add('title', null, [
                'row_attr' => ['class' => 'col-md-12'],
                'label' => 'Titre de votre annonce',

            ])
            ->add('price', null, [
                'row_attr' => ['class' => 'col-md-2'],
                'label' => 'Prix',

            ])
            ->add('sportConcerned', EntityType::class, [
                'class' => Sport::class,
                'row_attr' => ['class' => 'col-md-5'],
                'label' => 'Sport concerné par l\'annonce',
            ])
            ->add('objectForSale', null, [
                'row_attr' => ['class' => 'col-md-5'],
                'label' => 'Objet que vous souhaitez vendre',
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                'label' => 'Enregistrer mon annonce',
                'row_attr' => ['class' => 'd-flex justify-content-center'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClassifiedAd::class,
        ]);
    }
}
