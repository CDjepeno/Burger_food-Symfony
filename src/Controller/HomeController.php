<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_menus")
     */
    public function index(ProductRepository $product): Response
    {
        return $this->render('home/home.html.twig',[
            "products" => $product->findAll()
        ]);
    }
}
