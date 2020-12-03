<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * Permet de récupérer tous les burgers
     * 
     * @Route("/products-burger/", name="products_burger")
     * 
     * @return Response
     */
    public function burgers(ProductRepository $product): Response
    {
        return $this->render('product/products_cat.html.twig', [
            'products' => $product->getProductsByBurger(),
        ]);
    }
    /**
     * Permet de récupérer tous les snacks
     * 
     * @Route("/products-snack/", name="products_snack")
     * 
     * @return Response
     */
    public function snacks(ProductRepository $product): Response
    {
        return $this->render('product/products_cat.html.twig', [
            'products' => $product->getProductsBySnack(),
        ]);
    }
    /**
     * Permet de récupérer toutes les salades
     * 
     * @Route("/products-salade/", name="products_salade")
     * 
     * @return Response
     */
    public function salades(ProductRepository $product): Response
    {
        return $this->render('product/products_cat.html.twig', [
            'products' => $product->getProductsBySalade(),
        ]);
    }
    /**
     * Permet de récupérer toutes les boissons
     * 
     * @Route("/products-drink/", name="products_drink")
     * 
     * @return Response
     */
    public function drink(ProductRepository $product): Response
    {
        return $this->render('product/products_cat.html.twig', [
            'products' => $product->getProductsByDrink(),
        ]);
    }
    /**
     * Permet de récuperer tous les desserts
     * 
     * @Route("/products-dessert/", name="products_dessert")
     * 
     * @return Response
     */
    public function dessert(ProductRepository $product): Response
    {
        return $this->render('product/products_cat.html.twig', [
            'products' => $product->getProductsByDessert(),
        ]);
    }
}
