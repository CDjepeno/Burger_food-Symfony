<?php
namespace App\Controller\Purchase;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
use App\purchase\PurchasePersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseConfirmationController extends AbstractController
{
    protected $cartService;
    protected $manager;
    protected $persister;

    public function __construct(CartService $cartService, EntityManagerInterface $manager, PurchasePersister $persister )
    {
        $this->cartService = $cartService; 
        $this->manager = $manager; 
        $this->persister = $persister; 
    }
    
    /**
     * Permet de gérer le forumulaire de commande
     * 
     * @Route("/purchase/confirm", name="purchase_confirm")
     * @IsGranted("ROLE_USER", message="vous devez être connecté pour confirmer votre commande")
     *
     * @return Response
     */
    public function confirm(Request $request): Response
    {
        $form = $this->createForm(CartConfirmationType::class);

        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            $this->addFlash(
                "warning",
                "Vous devez remplir le formulaire de confirmation"
            );

            return $this->redirectToRoute("cart_show");
        }

        $customer = $this->getUser();

        $cartItems = $this->cartService->getDetailedCart();

        if(count($cartItems) === 0){
            $this->addFlash(
                "warning",
                "Vous ne pouvez confirmer une commande avec un panier vide"
            );

            return $this->redirectToRoute("cart_show");
        }

        /** @var Purchase */
        $purchase = $form->getData();

        $this->persister->storePurchase($purchase);

        return $this->redirectToRoute('purchase_payment_form',[
            "id" => $purchase->getId()
        ]);    
    }
    
}