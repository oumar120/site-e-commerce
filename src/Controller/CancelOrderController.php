<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CancelOrderController extends AbstractController
{
    #[Route('/commande/erreur/{checkout_session_id}', name: 'cancel_order')]
    public function index($checkout_session_id,OrderRepository $or): Response
    { 
        $order=$or->findOneByCheckoutSessionId($checkout_session_id);
        if(!$order || $order->getUser()!=$this->getUser()){
            return $this->redirectToRoute('home');
        }
        return $this->render('cancel_order/index.html.twig', [
            'order'=>$order
        ]);
    }
}
