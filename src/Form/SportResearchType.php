<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SportResearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'attr' => ['class' => 'form-control search-slt', 'placeholder' => 'Sport'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
                'placeholder' => 'Sport',
            ])
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'attr' => ['class' => 'form-control search-slt', 'placeholder' => 'Sport'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
                'placeholder' => 'Niveau',
            ])
            ->add('age', null, [
                'attr' => ['class' => 'form-control search-slt', 'placeholder' => 'Âge'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
            ])
            ->add('city', null, [
                'attr' => ['class' => 'form-control search-slt', 'placeholder' => 'Ville'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'btn btn-danger wrn-btn'],
                'label' => 'rechercher',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
