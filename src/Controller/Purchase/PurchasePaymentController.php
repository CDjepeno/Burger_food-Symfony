<?php
namespace App\Controller\Purchase;

use Stripe\Stripe;
use App\Entity\Purchase;
use Stripe\PaymentIntent;
use App\Stripe\StripeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentController extends AbstractController {

    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Permet d'afficher le formulaire de paiement
     * 
     * @Route("/purchase/pay/{id}", name="purchase_pay")
     * @IsGranted("ROLE_USER", message="vous devez être connecté pour effectuer un paiement")
     * 
     * @return Response
     */
    public function payment(Purchase $purchase): Response
    {
         return $this->stripeService->getPayment($purchase);
    }
    
}