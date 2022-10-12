<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetail;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'order')]
    public function index(Cart $cart,Request $request): Response
    {
    
        if(!$this->getUser()->getAddresses()->getValues()){
            return $this->redirectToRoute('adresse_ad');
        }
        $form=$this->createForm(OrderType::class,null,[
            'user'=>$this->getUser()
        ]);
        return $this->render('order/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=>$cart->getFull()
        ]);
    }

    #[Route('/commande/recapitulatif', name: 'recap',methods:["POST"])]
    public function add(Cart $cart,Request $request,ObjectManager $manager): Response
    {
    
        $form=$this->createForm(OrderType::class,null,[
            'user'=>$this->getUser()
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $carries=$form->get('carries')->getData();
            $address=$form->get('address')->getData();
            $date=new \DateTime();
            $content=$address->getName().'<br>';
            $content.=$address->getFirstname().' '.$address->getLastname().'<br>';
            $content.=$address->getPhone().'<br>';
            $content.=$address->getCompany().'<br>';
            $content.=$address->getAddress().'<br>';
            $content.=$address->getPostal().'-'.$address->getCity().'-'.$address->getCountry().'<br>';
            $order=new Order();
            $order->setReference($date->format('dmy').'_'.uniqid());
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carries->getName());
            $order->setCarrierPrice($carries->getPrice());
            $order->setDelivery($content);
            $order->setState(0);
            $manager->persist($order);
            
            foreach($cart->getFull() as $product){
                $orderDetail= new OrderDetail();
                $orderDetail->setMyorder($order);
                $orderDetail->setProduct($product['product'][0]->getName());
                $orderDetail->setQuantity($product['quantity']);
                $orderDetail->setPrice($product['product'][0]->getPrice());
                $orderDetail->setTotal($product['quantity']*$product['product'][0]->getPrice());
                $manager->persist($orderDetail);
            }
            $manager->flush();
            return $this->render('order/add.html.twig',[
                'cart'=>$cart->getFull(),
                'order'=>$order,
                'carries'=>$carries,
                'reference'=>$order->getReference()
            ]);
        }
        return $this->redirectToRoute('panier');
    }
}
