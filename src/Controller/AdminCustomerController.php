<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCustomerController extends AbstractController
{
    /**
     * Permet de d'afficher la liste des clients
     * 
     * @Route("/admin/customers", name="admin_customers")
     * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas le droit d'acceder à cette ressource")
     * 
     * @return Response
     */
    public function index(CustomerRepository $customer): Response
    {
        return $this->render('admin_customer/index.html.twig', [
            'customers' => $customer->findAll(),
        ]);
    }

    /**
     * Permet de supprimer un Utilisateur
     * 
     * @Route("/admin/delete/{id}", name="admin_delete_customer", methods="delete")
     * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas le droit d'acceder à cette ressource")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Customer $customer
     * 
     * @return Response
     */
    public function delete(Customer $customer, Request $request,EntityManagerInterface $em) : Response
    {
        if($this->isCsrfTokenValid("SUP". $customer->getId(), $request->get('_token'))){
 
            $em->remove($customer);
            $em->flush();
 
            $this->addFlash(
                "danger",
                "l'utilisateur a bien été supprimer"
            );
 
            return $this->redirectToRoute('admin_customers');
        }
    }

    /**
     * Permet d'affichger la liste des commandes d'un clients
     * 
     * @Route("admin/purchases/{slug}", name="admin_purchase")
     */
    public function purchase(Customer $customer)
    {
        
        return $this->render("purchase/index.html.twig",[
            "purchases"      => $customer->getPurchases(), 
            "username"       => $customer->getUsername(),
            "total_purchase" => $customer->totalpurchase()
        ]);
    }
}
