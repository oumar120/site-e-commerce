<?php
namespace App\Classe;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart 
{
    private $session;
    private $pr;
    public function __construct(RequestStack $rs,ProductRepository $pr){
         $this->session=$rs->getSession();
         $this->pr=$pr;
    }

    public function add($id){
        $cart=$this->session->get('cart',[]);
        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id]=1;
        }
        $this->session->set('cart',$cart);
    }
    public function get(){
        return $this->session->get('cart');
    }
    public function remove(){
       $this->session->remove('cart');
    }
    public function delete($id){
        $cart=$this->session->get('cart',[]);
        unset($cart[$id]);
        return $this->session->set('cart',$cart);
    }
    public function discrease($id){
        $cart=$this->session->get('cart',[]);
        // dd($cart[$id]);
        if($cart[$id]==1){
           $this->delete($id);
        }else{
           $cart[$id]--;
           return $this->session->set('cart',$cart);
        }
        
    }
    public function getFull(){
        $carts=$this->get();
           $paniers=[];
           if($carts){
            foreach($carts as $id=>$quantity){
                $produit=$this->pr->findById($id);
               if(!$produit){
                   $this->delete($id);
                   continue;
               }
               $paniers[]=[
                   'product'=>$produit,
                   'quantity'=>$quantity
               ];
              
              }
           }
           
           return $paniers;
    }
    
} 