<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class,[
                'label'=>'prenom',
                'attr'=>[
                    'placeholder'=>'votre prénom'
                ],
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>10
                ])
            ])
            ->add('lastName',TextType::class,[
                'label'=>'nom',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>10
                ]),
                'attr'=>[
                    'placeholder'=>'votre nom'
                ]
            ])
            ->add('email',TextType::class,[
                'label'=>'votre email',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>50
                ]),
                'attr'=>[
                    'placeholder'=>'vous devez saisir un email'
                ]
            ])
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
                'label'=>'enregistrer'
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
