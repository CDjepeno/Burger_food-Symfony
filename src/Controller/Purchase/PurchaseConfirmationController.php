<?php
namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Form\CartConfirmationType;
use App\purchase\PurchasePersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PurchaseConfirmationController extends AbstractController
{
    protected $cartService;
    protected $persister;
    protected $manager;
    
    public function __construct(CartService $cartService, EntityManagerInterface $manager, PurchasePersister $persister )
    {
        $this->cartService = $cartService; 
        $this->manager     = $manager; 
        $this->persister   = $persister;  
    }
    
    /**
     * Permet de gérer le formulaire de commande
     * 
     * @Route("/purchase/confirm", name="purchase_confirm")
     *
     * @return Response
     */
    public function confirm(Request $request): Response
    {
        $form      = $this->createForm(CartConfirmationType::class);
        $cartItems = $this->cartService->getDetailedCart();

        if(count($cartItems) === 0){
            $this->addFlash(
                "warning",
                "Vous ne pouvez confirmer une commande avec un panier vide"
            );
            return $this->redirectToRoute("cart_show");
        }

        $form->handleRequest($request);

        /** @var Purchase */
        $purchase = $form->getData();

        $this->persister->storePurchase($purchase);
    
        return $this->render("purchase/payment.html.twig",[
            "purchase" => $purchase
        ]);
    }
    
}