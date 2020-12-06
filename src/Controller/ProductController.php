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
     * @Route("/category/products/{id}", name="products_category")
     * 
     * @return Response
     */
    public function products(ProductRepository $product,$id): Response
    {
        return $this->render('product/products_cat.html.twig', [
            'products' => $product->getProductByCategory($id),
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


}
