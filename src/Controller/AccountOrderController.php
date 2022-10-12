<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{
    #[Route('/compte/mes-commandes', name: 'account_order')]
    public function index(OrderRepository $or): Response
    {
            $orders=$or->findOrderSuccess($this->getUser());
        return $this->render('account/order.html.twig', [
            'orders'=>$orders
        ]);
    }
    #[Route('/compte/commande_details/{reference}',name:'account_orderdetail')]
    public function main($reference,OrderRepository $or)
    {
        $order=$or->findOneByReference($reference);
        return $this->render('account/orderdetail.html.twig', [
            'order'=>$order
        ]); 
    }
}
