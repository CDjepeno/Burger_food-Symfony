<?php
namespace App\Controller\Purchase;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasesListController extends AbstractController 
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    /**
     * Permet d'afficher la liste des commandes d'un utilateur
     * 
     * @Route("/purchases", name="purchase_index")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour accéder à vos commandes")
     *
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render("purchase/index.html.twig",[
            "purchases" => $user->getPurchases()
        ]);
    } 
    
}