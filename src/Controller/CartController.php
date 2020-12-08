<?php

namespace App\Controller;

use App\Cart\CartService;
use App\Form\CartConfirmationType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    protected $productRepo;
    protected $cartService;

    public function __construct(ProductRepository $productRepo, CartService $cartService)
    {
        $this->productRepo = $productRepo;
        $this->cartService = $cartService;
    }

    /**
     * Permet de d'ajouter un produit au panier
     * 
     * @Route("/customer/cart/add/{id<\d+>}", name="cart_add")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function add(int $id, Request $request): Response
    {
        $product = $this->productRepo->find($id);

        if(!$product) {
            throw $this->createNotFoundException("Le produit $id n'existe pas");
        }

        $this->cartService->add($id);

        $this->addFlash(
            "success",
            "Le produit a bien été ajouté au panier"
        );
        
        if($request->query->get('returnToCart')) {
            return $this->redirectToRoute("cart_show");
        }

       return $this->redirectToRoute("product_show",[
           "slug" => $product->getSlug()
       ]);
    }

    /**
     * Permet d'afficher le panier
     *
     * @Route("/customer/cart", name="cart_show")
     * 
     * @return Response
     */
    public function show(): Response
    {
        $detailedCart = $this->cartService->getDetailedCart();
        $total        = $this->cartService->getTotal();

        $form         = $this->createForm(CartConfirmationType::class);

        return $this->render("cart/index.html.twig",[
            "items" => $detailedCart,
            "total" => $total,
            "form"  => $form->createView()
            
        ]);
    }

    /**
     * Permet de supprimer un produit du panier
     * 
     * @Route("/customer/cart/delete/{id<\d+>}", name="cart_delete")
     *
     */
    public function delete(int $id)
    {
        $product = $this->productRepo->find($id);

        if(!$product) {
            return $this->createNotFoundException("Le produit $id n'existe pas");
        }

        $this->cartService->remove($id);

        $this->addFlash(
            "danger",
            "Le produit a bien été supprimer"
        );

        return $this->redirectToRoute("cart_show");
    }

    /**
     * Permet de décrémenter le nombre de produit
     *
     * @Route("/customer/cart/decrement/{id<\d+>}", name="cart_decrement")
     * 
     * @return void
     */
    public function decrement(int $id)
    {
        $product = $this->productRepo->find($id);

        if(!$product) {
            return $this->createNotFoundException("Le produit $id n'existe pas");
        }

        $this->cartService->decrement($id);

        $this->addFlash(
            "success",
            "Le produit a bien été décrémenté"
        );

        return $this->redirectToRoute("cart_show");
    }

    
}
