<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
