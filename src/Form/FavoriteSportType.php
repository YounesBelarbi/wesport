<?php

namespace App\Form;

use App\Entity\FavoriteSport;
use App\Entity\Level;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FavoriteSportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('sport', null, [
                'row_attr' => ['class' => 'col-md-6'],
            ])
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'row_attr' => ['class' => 'col-md-6'],
                
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                'label' => 'Enregistrer',
                'row_attr' => ['class' => 'd-flex justify-content-center'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FavoriteSport::class,
        ]);
    }
}
