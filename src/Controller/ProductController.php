<?php

namespace App\Controller;

use App\Entity\Product;
use App\Event\ProductViewEvent;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
    public function show(Product $product, EventDispatcherInterface $dispatcher): Response
    {
        if(!$product){
            throw $this->createNotFoundException("Le produit demander n'existe pas");
        }
         // Ont lance un évènement qui permet aux autres dev de réagir à la prise d'une commande  
        $productEvent = new ProductViewEvent($product);

        $dispatcher->dispatch($productEvent,"product.view");

        return $this->render('product/show.html.twig',[
            "product" => $product
        ]);
    }

    /**
     * Permet de trouver un produit en fonction d'une recherche
     * 
     * @Route("/products/search", name="product_search", methods="POST")
     *
     * @return Response
     */
    public function searchProduct(Request $request, ProductRepository $product): Response
    {
        if ($request->getMethod() == Request::METHOD_POST){
            $data = $request->request->get('search');
            
            return $this->render("product/products_search.html.twig",[
                "products" => $product->getProductsBySearch($data)
            ]);
        }

    }


}
