<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
            ->add('email', null, [
                'row_attr' => ['class' => 'col-md-12'],
            ])
            ->add('username', null, [
                'row_attr' => ['class' => 'col-md-12'],
                'label' => 'Pseudonyme'
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
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ])
                ],
                'options' => ['row_attr' => ['class' => 'col-md-6']],
                'first_options'  => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'invalid_message' => 'Les mots de passe doivent être identiques',
            ])
            ->add('age', null, [
                'row_attr' => ['class' => 'col-md-2'],
                'label' => 'Âge',
                'required' => false
            ])
            ->add('lastname', null, [
                'row_attr' => ['class' => 'col-md-5'],
                'label' => 'Nom',
                'required' => false
            ])
            ->add('firstname', null, [
                'row_attr' => ['class' => 'col-md-5'],
                'label' => 'Prénom',
                'required' => false
            ])
            ->add('city', null, [
                'row_attr' => ['class' => 'col-md-6'],
                'label' => 'Ville',
                'required' => false
            ])
            ->add('phonenumber', TelType::class, [
                'row_attr' => ['class' => 'col-md-6'],
                'label' => 'Numéro de téléphone',
                'required' => false
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                'label' => 'Je valide mon profile',
                'row_attr' => ['class' => 'd-flex justify-content-center'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
