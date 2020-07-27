<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $user = $event->getData();

        if ($user == null) {
            $form
                ->add('email', null, [
                    'mapped' => false
                ])
                ->add('send', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                    'label' => 'Recevoir le lien',
                    'row_attr' => ['class' => 'd-flex justify-content-center'],
                ]);
        } else {
            $form
                ->add('email')
                ->add('username')
                ->add('age')
                ->add('lastName')
                ->add('firstName')
                ->add('city')
                ->add('phoneNumber')
                ->add('description', TextareaType::class)
                ->add('profileImage', FileType::class,[
                    'label' => 'photo (format: jpeg)',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'mimeTypes' => [
                                'image/jpeg',
                            ],
                            'mimeTypesMessage' => 'seul le format jpeg est supporté',
                            ])
                        ],
                        
                        ])
                ->add('send', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-lg btn-primary site-btn col-md-6'],
                    'label' => 'enregistrer les modifications',
                    'row_attr' => ['class' => 'd-flex justify-content-center'],
                ]);
        }
    }
}
