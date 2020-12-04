<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCustomerController extends AbstractController
{
    /**
     * Permet de d'afficher la liste des clients
     * 
     * @Route("/admin/customers", name="admin_customers")
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
     * @Route("/delete/{id}", name="admin_delete_customer", methods="delete")
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
}
