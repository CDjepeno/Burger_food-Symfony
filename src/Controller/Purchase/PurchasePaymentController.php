<?php
namespace App\Controller\Purchase;

use Stripe\Stripe;
use App\Entity\Purchase;
use Stripe\PaymentIntent;
use App\Repository\PurchaseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentController extends AbstractController {

    // protected $secretKey;
    // protected $publicKey;

    // public function __construct(string $secretKey, string $publicKey)
    // {
    //     $this->secretKey = $secretKey;
    //     $this->publicKey = $publicKey;
    // }

    /**
     * Permet d'afficher le formulaire de paiement
     *
     * @Route("/purchase/pay/{id}", name="purchase_payment_form")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function showCardForm($id, PurchaseRepository $purchase): Response
    {
        // dd($request);
        $purchase = $purchase->find($id);

        // if(
        //     !$purchase ||
        //     ($purchase && $purchase->getCustomer() !== $this->getUser()) ||
        //     ($purchase && $purchase->getCustomer() === Purchase::STATUS_PAID) 
        //   )
        // {
        //     return $this->redirectToRoute("cart_show");
        // }
        
        \Stripe\Stripe::setApiKey("sk_test_51HwK6oJzFZT0NUHQepAZveSRE2Okod51iPZD1RRUZFHU9dXb4Kg7LPYP8OumOTE27kvYDUjDu3mvQDd5heIF4xHe00AFLtlR07");

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                  'name' => 'ok',
                ],
                'unit_amount' => 1000,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl("purchase_payement_success",["id"=> $purchase->getId()],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl("error",[],UrlGeneratorInterface::ABSOLUTE_URL),
          ]);

          return new JsonResponse([ 'id' => $session->id ]);

    }
    
}