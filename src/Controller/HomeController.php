<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_menus")
     */
    public function index(ProductRepository $product): Response
    {
        return $this->render('home/home.html.twig',[
            "products" => $product->getProductsByMenu()
        ]);
    }
}
