<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=>'votre email'
                ],
                'disabled'=>true
            ])
            ->add('firstName',TextType::class,[
                'attr'=>[
                    'placeholder'=>'votre prenom'
                ],
                'disabled'=>true
            ])
            ->add('lastName',TextType::class,[
                'attr'=>[
                    'placeholder'=>'votre nom'
                ],
                'disabled'=>true
            ])
            ->add('old_password',PasswordType::class,[
                'label'=>'votre mot de passe actuel',
                'mapped'=>false,
                'attr'=>['placeholder'=>'saisissez votre ancien mot de passe']
            ])
            ->add('new_password',RepeatedType::class,[
                'mapped'=>false,
                'type'=>PasswordType::class,
                'invalid_message'=>'le mot de passe saisi doit etre identique',
                'first_options'=>[
                    'attr'=>['placeholder'=>'nouveau mot de passe'],
                    'label'=>'saisissez votre nouveau mot de passe'
                ],
                'second_options'=>[
                    'attr'=>['placeholder'=>'confirmation de mot de passe'],
                    'label'=>'confirmer votre mot de passe'
                ]

            ])
            ->add('submit',SubmitType::class,[
                'label'=>'mise à jour'
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
