<?php
namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('searchByName',TextType::class,[
            'label'=>false,
            'attr'=>[
                'placeholder'=>'rechercher...'
            ],
            'required'=>false
            ])
        ->add('searchByCategory',EntityType::class,[
            'class'=>Category::class,
            'label'=>false,
            'required'=>false,
            'multiple'=>true,
            'expanded'=>true
        ])
        ->add('submit',SubmitType::class,[
            'label'=>'filtrer',
            'attr'=>[
                'class'=>'btn-block btn-info' 
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET'
        ]);
    }
}