<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'donner un nom à l adresse'
                ]
            ])
            ->add('firstname',TextType::class,[
                'label'=>'Prenom',
                'attr'=>[
                    'placeholder'=>'votre prénom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'votre nom'
                ]
                ])
            ->add('company',TextType::class,[
                'label'=>'company',
                'attr'=>[
                    'placeholder'=>'le nom de votre societé'
                ]
                ])
            ->add('address',TextType::class,[
                'label'=>'votre adresse',
                'attr'=>[
                    'placeholder'=>'saisissez votre adresse'
                ]
                ])
            ->add('postal',TextType::class,[
                'label'=>'code postal',
                'attr'=>[
                    'placeholder'=>'saisissez votre code postal'
                ]
                ])
            ->add('city',TextType::class,[
                'label'=>'Ville',
                'attr'=>[
                    'placeholder'=>'indiquer votre ville'
                ]
                ])
            ->add('country',CountryType::class,[
                'label'=>'Pays',
                'attr'=>[
                    'placeholder'=>'indiquer votre pays'
                ]
                ])
            ->add('phone',TelType::class,[
                'label'=>'Téléphone',
                'attr'=>[
                    'placeholder'=>'votre numéro de téléphone'
                ]
                ])
            ->add('submit',SubmitType::class,[
                'label'=>'soumettre',
                'attr'=>[
                    'class'=>'btn btn-info btn-block'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
