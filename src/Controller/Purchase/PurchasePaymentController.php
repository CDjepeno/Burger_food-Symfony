<?php
namespace App\Controller\Purchase;

use Stripe\Stripe;
use App\Entity\Purchase;
use Stripe\PaymentIntent;
use App\Repository\PurchaseRepository;
use App\Stripe\StripeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class PurchasePaymentController extends AbstractController {

    /**
     * Permet d'afficher le formulaire de paiement
     *
     * @Route("/purchase/pay/{id}", name="purchase_payment_form")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function showCardForm($id, PurchaseRepository $purchase, StripeService $stripeService): Response
    {
        $purchase = $purchase->find($id);

        if(
            !$purchase ||
            ($purchase && $purchase->getCustomer() !== $this->getUser()) ||
            ($purchase && $purchase->getCustomer() === Purchase::STATUS_PAID) 
          )
        {
            return $this->redirectToRoute("cart_show");
        }
        
      $intent = $stripeService->getPaymentIntent($purchase);

        return $this->render("purchase/payment.html.twig",[
            'clientSecret' => $intent->client_secret,
            'purchase'     => $purchase
        ]);
    }
    
}