<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use Stripe\Checkout\Session;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/commande/stripe-checkout/{reference}', name: 'stripe')]
    public function index(Cart $cart,OrderRepository $or,$reference,ProductRepository $pr,ObjectManager $manager): Response
    {
        $stripe_item=[];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        Stripe::setApiKey('sk_test_51Lpz4IAWPdHQHPVQkqi5VgYTOSgbBZj9vtoexog1V1Nqh6RqDpt4q98OCOAukc5dbpTtsGpZHRJkxZAFrY258iA0000NCrGHok');
        $order=$or->findOneByReference($reference);
        
        foreach($order->getOrderDetails()->getValues() as $product){
        
           $productObject=$pr->findOneByName($product->getProduct());
            $stripe_item[]=[
                'price_data'=>[
                    'currency'=>'xof',
                    'unit_amount'=>$product->getPrice()/100,
                    'product_data'=>[
                        'name'=>$product->getProduct(),
                        'images'=>[$YOUR_DOMAIN."/images/".$productObject->getIllustration()]
                    ]
                    ],
                'quantity' => $product->getQuantity()
            ];
            $stripe_item[]=[
                'price_data'=>[
                    'currency'=>'xof',
                    'unit_amount'=>$product->getMyorder()->getCarrierprice(),
                    'product_data'=>[
                        'name'=>$product->getMyorder()->getCarrierName(),
                        'images'=>[]
                    ]
                    ],
                'quantity' => 1
            ];
        }
        
     $checkout_session =Session::create([
        'customer_email'=>$this->getUser()->getEmail(),
        'line_items' => [
            $stripe_item
        ],
           'mode' => 'payment',
          'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
          'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
]);
       $order->setCheckoutSessionId($checkout_session->id);
        $manager->flush();
      return $this->redirect($checkout_session->url);
    }
}
