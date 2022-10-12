<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    #[Route('/commande/merci/{checkout_session_id}', name: 'order_success')]
    public function index($checkout_session_id,OrderRepository $or,Cart $cart,ObjectManager $manager): Response
    {
        $user=$this->getUser();
        $order=$or->findOneByCheckoutSessionId($checkout_session_id);
        if(!$order || $order->getUser()!=$this->getUser()){
            return $this->redirectToRoute('home');
        }
        if($order->getState()==0){
            $cart->remove();
            $order->setState(1);
            $manager->flush();
            
            //envoyer un email à l utilisateur
            $mail=new Mail();
            $content="bonjour ".$user->getFirstName().' '.$user->getLastName().'<br>'."nous confirmons votre commande n°".$order->getReference();
            $mail->send($user->getEmail(),$user->getFirstName(),'commande confirmée',$content);
        }
        return $this->render('order_success/index.html.twig',[
            'order'=>$order
        ]);
    }
}
