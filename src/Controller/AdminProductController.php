<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AbstractController
{
    /**
     * Permet d'afficher tous les produits
     * 
     * @Route("/admin/products", name="admin_products")
     * 
     * @param ProductRepository $products
     * 
     * @return Response
     */
    public function index(ProductRepository $products): Response
    {
        return $this->render('admin_product/index.html.twig', [
            'products' => $products->findAll(),
        ]);
    }
}
