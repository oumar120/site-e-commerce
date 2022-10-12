<?php

namespace App\Controller;

use App\Classe\Search;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/nos-produit', name: 'produit')]
    public function index(ProductRepository $pr,Request $request): Response
    {
        $search=new Search();
        $form=$this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $products=$pr->findBySearch($form->getData());
        }else{
            $products=$pr->findAll();
        }
        
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form'=>$form->createView()
        ]);
    }

    #[Route('/produit/{slug}',name:"single_product")]
    public function show(ProductRepository $pr,$slug){
        $product=$pr->findOneBy([
            'slug'=>$slug
        ]);
        $products=$pr->findByIsBest(1);
        if(!$product){
            return $this->redirectToRoute('produit');
        }
        return $this->render('product/product.html.twig',[
            'product'=>$product,
            'products'=>$products
        ]);
    }
}
