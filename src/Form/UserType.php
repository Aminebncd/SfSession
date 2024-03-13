<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles')
            // ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                     'homme' => 'homme',
                     'femme' => 'femme',
                     'autre'=> 'autre'
                ]
            ])
            ->add('ville')
            ->add('telephone')
            ->add('valider', SubmitType::class, [
                'attr' => [
                    // 'class' => 'btn btn-primary mt-3'
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