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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * 
     * @return Response
     */
    public function payment(Purchase $purchase): Response
    {
         return $this->stripeService->getPayment($purchase);
    }
    
}