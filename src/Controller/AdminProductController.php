<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProductController extends AbstractController
{
    /**
     * Permet d'afficher tous les produits
     * 
     * @Route("/admin/products", name="admin_products")
     * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas le droit d'acceder à cette ressource")
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

    /**
     * Permet d'ajouter et de modifier un produit
     *
     * @Route("/admin/add", name="admin_add")
     * @Route("/admin/update/{slug}", name="admin_update")
     * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas le droit d'acceder à cette ressource")
     * 
     * @param Product $product
     * @param EntityManagerInterface $em
     * @param Request $request
     * 
     * @return Response
     */
    public function addUpdateProduct(?Product $product, EntityManagerInterface $em, Request $request):Response
    {
        if(!$product){
            $product = new Product;
        }

        $form = $this->createForm(ProductType::class,$product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $update = $product->getId() ==! null;
            $em->persist($product);
            $em->flush();

            $this->addFlash(
                "success",
                ($update) ? "La modification a bien été éffectuer" : "Le produit a bien été ajouter"
            );

            return $this->redirectToRoute("admin_products");
        }
        return $this->render("admin_product/addUpdateProduct.html.twig",[
            "form"     => $form->createView(),
            "isUpdate" => $product->getId() ==! null,
            "product"  => $product
        ]);
    }

    /**
     * Permet de supprimer un produit
     * 
     * @Route("/admin/delete/{slug}", name="admin_delete_product", methods="sup")
     * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas le droit d'acceder à cette ressource")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Product $product
     * 
     * @return Response
     */
    public function delete(Product $product, Request $request,EntityManagerInterface $em) : Response
    {
        if($this->isCsrfTokenValid("SUP". $product->getId(), $request->get('_token'))){
 
            $em->remove($product);
            $em->flush();
 
            $this->addFlash(
                "danger",
                "Le produit a bien été supprimer"
            );
 
            return $this->redirectToRoute('admin_products');
        }
    }
}
