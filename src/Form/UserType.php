<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control column'
                ]
            ])
            // ->add('roles')
            // ->add('password')
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control column'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control column'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control column'
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                     'homme' => 'homme',
                     'femme' => 'femme',
                     'autre'=> 'autre'
                ],
                'attr' => [
                    'class' => 'form-control column'
                ]
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control column'
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'form-control column'
                ]
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                    ]
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}