<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
   
    /**
     * Permet de récupérer tous les produits d'une categorie
     * 
     * @Route("/products/{id}", name="products")
     * 
     * @return Response
     */
    public function burgers(ProductRepository $product,$id): Response
    {
        return $this->render('product/products_cat.html.twig', [
            'products' => $product->getProductByCategory($id),
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

    /**
     * Permet d'afficher un produit
     *
     * @Route("/product/{slug}", name="product_show")
     * 
     * @param Product $product
     * 
     * @return Response
     */
    public function show(Product $product): Response
    {
        if(!$product){
            throw $this->createNotFoundException("Le produit demander n'existe pas");
        }
        return $this->render('product/show.html.twig',[
            "product" => $product
        ]);
    }

     /**
     * Permet de recupéter des produits par catégories
     *
     * @Route("/category/{id_category}", name="product_cat")
     * 
     * @param ProductRepository $product
     * @param [int] $id_category
     * 
     * @return Response
     */
    public function productsByCategory(ProductRepository $product,$id_category)
    {
        return $this->render('product/products_cat.html.twig',[
            "products" => $product->getProductByCategory($id_category)
        ]);
    }
}
