<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'signup')]
    public function index(Request $request, ObjectManager $manager,UserPasswordHasherInterface $hasher,
    UserRepository $ur): Response
    {
        $notification=null;
        $user=new User();
        $form=$this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $emailSearch=$ur->findOneByEmail($user->getEmail());
            if(!$emailSearch){
                $hash=$hasher->hashPassword($user,$user->getPassword());
                $user->setPassword($hash);
                //dd($form->getData());
                $manager->persist($user);
                $manager->flush();
                //return $this->redirectToRoute('login');
                $mail=new Mail();
                $content="bonjour ".$user->getFirstName().' '.$user->getLastName().'<br>'."merci d'avoir choisi la boutique sénégalaise";
                $mail->send($user->getEmail(),$user->getFirstName(),'confirmation d\'inscription',$content);
                $notification="votre inscription s'est déroulée avec succes";
            }else{
                $notification="l'email que vous avez saisi existe déjà";
            }
            
        }
        return $this->render('register/index.html.twig',[
            'form'=>$form->createView(),
            'notification'=>$notification
        ]);
    }
}
