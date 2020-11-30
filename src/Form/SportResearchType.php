<?php

namespace App\Form;


use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SportResearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'attr' => ['class' => 'form-control search-slt select', 'placeholder' => 'Sport', 'data-name' => 'sport'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
                'placeholder' => 'Sport',
            ])
            ->add('city', TextType::class, [        
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,           
                'attr' => ['class' => 'form-control search-slt city select','placeholder' => 'Ville','data-name' => 'city'],              
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }   
}
