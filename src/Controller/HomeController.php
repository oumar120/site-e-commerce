<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $pr,HeaderRepository $hr): Response
    {
        $products=$pr->findByIsBest(1);
        $headers=$hr->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products'=>$products,
            'headers'=>$headers
        ]);
    }
}
