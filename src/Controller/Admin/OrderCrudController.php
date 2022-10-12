<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
    public function configureActions(Actions $actions):Actions
    {
        return $actions
               ->add(Crud::PAGE_INDEX,Action::DETAIL)
               ->disable(Action::DELETE,Action::NEW);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
            TextField::new('user.fullname','utilisateur')->hideOnForm(),
            TextField::new('carriername','transporteur')->hideOnForm(),
            MoneyField::new('carrierprice','frais de port')->setCurrency('XOF')->hideOnForm(),
            MoneyField::new('total')->setCurrency('XOF')->hideOnForm(),
            ChoiceField::new('state')->setChoices([
                'non payé'=>0,
                'payé'=>1,
                'en cours de préparation'=>2,
                'en cours de livraison'=>3
            ]),
            ArrayField::new('orderDetails','produits achetés')->hideOnForm(),
        ];
    }
    
}
