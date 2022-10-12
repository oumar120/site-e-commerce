<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('/mon-panier', name: 'panier')]
    public function index(Cart $cart): Response
    {   
        return $this->render('card/index.html.twig',[
                'paniers'=>$cart->getFull()
        ]);
    }
    #[Route('/card/add/{id}', name:"addToCart")]
    public function add($id,Cart $cart){
        $cart->add($id);
        return $this->redirectToRoute('panier');
    }
    #[Route('/card/remove',name:"removeToCard")]
    public function remove(Cart $card){
         $card->remove();
         return $this->redirectToRoute('produit');
    }
    #[Route('/card/delete/{id}',name:"deleteToCart")]
    public function delete(Cart $card,$id){
         $card->delete($id);
         return $this->redirectToRoute('panier');
    }
    #[Route('/card/discrease/{id}',name:"discrease")]
    public function discrease(Cart $card,$id){
         $card->discrease($id);
         return $this->redirectToRoute('panier');
    }
    
}
