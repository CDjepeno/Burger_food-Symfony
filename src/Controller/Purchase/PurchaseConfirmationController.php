<?php
namespace App\Controller\Purchase;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
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

    public function __construct(CartService $cartService, EntityManagerInterface $manager)
    {
        $this->cartService = $cartService; 
        $this->manager = $manager; 
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

        // dd($form->handleRequest($request));
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
        //  dd($cartItems);

        if(count($cartItems) === 0){
            $this->addFlash(
                "warning",
                "Vous ne pouvez confirmer une commande avec un panier vide"
            );

            return $this->redirectToRoute("cart_show");
        }

        /** @var Purchase */
        $purchase = $form->getData();

        $purchase->setCustomer($customer)
                 ->setPurchaseAt(new DateTime())
                 ->setAmount($this->cartService->getTotal());

        $this->manager->persist($purchase);

        foreach($this->cartService->getDetailedCart() as $cartItem) {
            $purchaseItem = new PurchaseItem();
            $purchaseItem ->setProduct($cartItem->product)
                          ->setPurchase($purchase)
                          ->setProductName($cartItem->product->getName())
                          ->setProductPrice($cartItem->product->getPrice())
                          ->setQuantity($cartItem->quantity)
                          ->setAmount($this->cartService->getTotal());
                          
            $this->manager->persist($purchaseItem);

        }

        $this->manager->flush();

        $this->cartService->empty();

        $this->addFlash(
            "success",
            "La commande a bien été enregistrée"
        );

        return $this->redirectToRoute('purchase_index');    
    }
    
}