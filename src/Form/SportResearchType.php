<?php

namespace App\Form;


use App\Entity\Sport;
use App\Service\RequestCity;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
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
            ])
            // ->add('departement',ChoiceType::class, [
            //     'choices' => $this->requestCityService->getDepartement(),
            //     'attr' => ['class' => 'form-control search-slt departement select',  'data-name' => 'departement'],
            //     'label' => false,
            //     'row_attr' => ['class' => 'd-flex justify-content-center'],
            //     'required' => false,
            //     'placeholder' => 'Département',
            // ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }   
}
