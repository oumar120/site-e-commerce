<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password',RepeatedType::class,[
            'type'=>PasswordType::class,
            'invalid_message'=>'le mot de passe saisi doit etre identique',
            'required'=>true,
            'first_options'=>[
                           'label'=>'mot de passe',
                           'attr'=>[
                            'placeholder'=>'saisissez votre mot de passe'
                           ]],
            'second_options'=>[
                      'label'=>'confirmer mot de passe',
                      'attr'=>[
                                'placeholder'=>'confirmez votre mot de passe'
                             ]]
        ])
        ->add('submit',SubmitType::class,[
            'label'=>'enregistrer',
            'attr'=>[
                'class'=>'btn btn-block btn-info'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
