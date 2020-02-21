<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',null, [
                'row_attr' => ['class' => 'col-md-12'],
            ])
            ->add('username',null, [
                'row_attr' => ['class' => 'col-md-12'],
                'label' => 'pseudonyme'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mots de passe doit contenir au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ])
                ],
                'options' => ['row_attr' => ['class' => 'col-md-6']],
                'first_options'  => [
                    'label' => 'mot de passe',
                    
                ],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'invalid_message' => 'Les mots de passe doivent être identiques',
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                'label' => 'Je valide mon profile',
                'row_attr' => ['class' => 'd-flex justify-content-center'],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
