<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangePasswordController extends AbstractController
{
    #[Route('/compte/password', name: 'change_password')]
    public function index(Request $request,ObjectManager $manager,UserPasswordHasherInterface $hash): Response
    { 
        $user= $this->getUser();
        //dd($user);
        $notification=null;
        $status=null;
        $form=$this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $old_password=$form->get('old_password')->getData();
              if($hash->isPasswordValid($user,$old_password)){
                  $new_password=$form->get('new_password')->getData();
                  $new_password=$hash->hashPassword($user,$new_password);
                  $user->setPassword($new_password);
                  $manager->persist($user);
                  $manager->flush();
                  $notification="votre mot de passe a bien été mis à jour";
                  $status="ok";
              }else{
                  $notification="le mot de passe que vous avez saisi ne correspond pas a votre mot de passe actuel";
                  $status="nok";
              }
        }
        return $this->render('account/password.html.twig', [
               'form'=>$form->createView(),
               'notif'=>$notification,
               'status'=>$status
        ]);
    }
}
