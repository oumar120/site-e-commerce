<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user=$options['user'];
        //dd($user);
        $builder
            ->add('address',EntityType::class,[
                'label'=>'choisissez votre adresse de livraison',
                'class'=>Address::class,
                'multiple'=>false,
                'expanded'=>true,
                'choices'=>$user->getAddresses()
            ])
            ->add('carries',EntityType::class,[
                'label'=>'choisissez votre transporteur',
                'class'=>Carrier::class,
                'multiple'=>false,
                'expanded'=>true
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'valider ma commande',
                'attr'=>[
                    'class'=>'btn btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user'=>[]
        ]);
    }
}
