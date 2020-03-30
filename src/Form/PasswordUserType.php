<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordUserType extends AbstractType
{
    private $configureOption = [];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', RepeatedType::class, [

                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mots de passe doit contenir au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ])
                ],
                'first_options'  => ['label' => 'Nouveau mot de passe', 'row_attr' => ['class' => 'col-md-12'],],
                'second_options' => ['label' => 'Confirmer le nouveau mot de passe', 'row_attr' => ['class' => 'col-md-12'],],
                'invalid_message' => 'Les mots de passe doivent être identiques',

            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])

            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                'label' => 'Je confirme mon nouveau mot de passe',
                'row_attr' => ['class' => 'd-flex justify-content-center'],
            ]);
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $user = $event->getData();

        if ($user) {
            $form
                ->add('oldPassword', PasswordType::class, [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'mapped' => false,
                    'label' => 'Mot de passe actuelle ',
                    'row_attr' => ['class' => 'col-md-12'],
                    'constraints' => new NotBlank(['message' => 'veuillez mettre votre ancien mot de passe']),

                ]);
        }
    }
}
