<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Service\RequestCity;

class SportResearchType extends AbstractType
{
    private $requestCityService;
    

    public function __construct(RequestCity $requestCityService)
    {
        $this->requestCityService = $requestCityService;
    }

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
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'attr' => ['class' => 'form-control search-slt select', 'placeholder' => 'Level', 'data-name' => 'level'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
                'placeholder' => 'Niveau',
            ])
            ->add('departement',ChoiceType::class, [
                'choices' => $this->requestCityService->getDepartement(),
                'attr' => ['class' => 'form-control search-slt departement', 'placeholder' => 'Âge', 'data-name' => 'age'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
            ])
            ->add('city', ChoiceType::class, [        
                'attr' => ['class' => 'form-control search-slt city', 'placeholder' => 'Ville', 'data-name' => 'city', 'disabled' => 'disabled'],
                'label' => false,
                'row_attr' => ['class' => 'd-flex justify-content-center'],
                'required' => false,
                'placeholder' => 'Ville',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
   
}
