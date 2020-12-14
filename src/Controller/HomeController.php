<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\PurchaseItemRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Afffichage de la page d'acceuil des produits les plus vendu
     * 
     * @Route("/", name="homepage")
     * 
     * @return Response
     */
    public function index(ProductRepository $product): Response
    {
        return $this->render('home/home.html.twig',[
            "products" => $product->findBestProductSale()
        ]);
    }
}
