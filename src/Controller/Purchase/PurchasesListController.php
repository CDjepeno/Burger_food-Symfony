<?php
namespace App\Controller\Purchase;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasesListController extends AbstractController 
{   

    /**
     * Permet d'afficher la liste des commandes d'un utilateur connecté
     * 
     * @Route("/purchases", name="purchase_index")
     *  
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->getUser();
        
        return $this->render("purchase/index.html.twig",[
            "purchases"     => $user->getPurchases(),
            "username"       => $user->getUsername(),
            "total_purchase" => $user->totalpurchase()
        ]);
    } 
    
}