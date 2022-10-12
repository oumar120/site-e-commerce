<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        $form=$this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $mail=new Mail();
           $fullname=$form->getData()['prenom'].' '.$form->getData()['nom'];
           $content='prenom et nom: '.$fullname.'<br> email: '.$form->getData()['email'].'<br>';
           $content.=$form->getData()['contenu'];
           $mail->send('baldeteste@gmail.com','admin','formulaire de contact',$content);
           $this->addFlash('notice','votre message à bien été envoyé!');
        }
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
