<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ResetPasswordRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordController extends AbstractController
{
    #[Route('/mot-de-passe-oublie', name: 'reset_password')]
    public function index(Request $request,UserRepository $ur,ObjectManager $manager): Response
    {
          $email=$request->get('email');
          if($email){
             $user=$ur->findOneByEmail($email);
             if($user){
                $resetPassword=new ResetPassword();
                $resetPassword->setUser($user);
                $resetPassword->setToken(uniqid());
                $resetPassword->setCreatedAt(new \DateTime());
                $manager->persist($resetPassword);
                $manager->flush();
                $url='http://127.0.0.1:8000';
                $url.=$this->generateUrl('update_password',[
                    'token'=>$resetPassword->getToken()
                ]);
                $content='bonjour '.$user->fullname().'<br>'.'vous avez demandé à réinitialiser votre mot de passe'.'<br><br>';
                $content.='merci de cliquer sur le bouton reinitialiser'.'<br>';
                $content.='<a type="button" href="'.$url.'">reinitialiser</a>';
                $email= new Mail();
                $email->send($user->getEmail(),$user->fullname(),'Réinitialisation de mot de passe',$content);
                $this->addFlash('notice','Un email vous a été envoyé,merci de vérifier votre boite mail');
             }
             else{
                $this->addFlash('notice','l email saisi n\' existe pas');
              }
          }
        return $this->render('reset_password/index.html.twig', [
        ]);
    }
    #[Route('/modifier-mot-de-passe/{token}',name:"update_password")]
    public function update($token,ResetPasswordRepository $rpr,Request $request,ObjectManager $manager,
    UserPasswordHasherInterface $hash,UserRepository $ur){
        $resetPassword=$rpr->findOneByToken($token);
        $user=$ur->findOneById($resetPassword->getUser()->getId());
        $now=new \DateTime();
        $session=$resetPassword->getCreatedAt()->modify('1 hour');
        if($now>$session){
           $this->addFlash('notice','votre demande de changement de mot de passe à expiré, veuillez effectuer une nouvelle demande');
           return $this->redirectToRoute('reset_password');
        }
        // on affiche une vue twig
          $form=$this->createForm(ResetPasswordType::class);
    
        // on encode les pass et effectue la modif
        //on redirige vers la page de connexion avec un message
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pass=$form->get('password')->getData();
            $passHasher=$hash->hashPassword($user,$pass);
            $user->setPassword($passHasher);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('notice','votre mot de passe a été changé avec succes');
            return $this->redirectToRoute('login');

        }
        return $this->render('reset_password/updatePass.html.twig',[
            'form'=>$form->createView()
          ]);
    }
}
