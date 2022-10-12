<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AdresseType;
use App\Repository\AddressRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddressController extends AbstractController
{
    #[Route('/compte/adresse', name: 'adresse')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig', [
            'controller_name' => 'AddressController',
        ]);
    }
    #[Route('/compte/adresse/edit/{id}',name:'adresse_edit')]
    #[Route('/compte/ajouter_adresse', name: 'adresse_ad')]
    public function add(Request $request, ObjectManager $manager,Address $adresse=null,Cart $cart): Response
    { 
        if(!$adresse){
            $adresse=new Address();
        }
        
        $form=$this->createForm(AdresseType::class,$adresse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $adresse->setUser($this->getUser());
            $manager->persist($adresse);
            $manager->flush();
            if($cart->get()){
             return $this->redirectToRoute('order'); 
            }else{
                return $this->redirectToRoute('adresse');
            }
          
        }else{
            return $this->render('account/addAdresse.html.twig', [
                'form' => $form->createView(),
            ]);
        }
       
    }
    #[Route('/compte/adresse/supprimer/{id}',name:'adresse_delete')]
    public function delete(ObjectManager $manager,AddressRepository $ar,$id){
        $adresse=$ar->findOneById($id);
           if($adresse && $adresse->getUser()==$this->getUser()){
              $manager->remove($adresse);
              $manager->flush();
            return $this->render('/account/address.html.twig');
           }else{
            return $this->redirectToRoute('adresse');
           }
    }
}
