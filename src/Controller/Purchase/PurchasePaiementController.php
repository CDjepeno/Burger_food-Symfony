<?php
namespace App\Controller\Purchase;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Repository\PurchaseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class PurchasePaiementController extends AbstractController {

    /**
     * Permet d'afficher le formulaire de paiement
     *
     * @Route("/purchase/pay/{id}", name="purchase_payment_form")
     * 
     * @return Response
     */
    public function showCardForm($id, PurchaseRepository $purchase): Response
    {
        $purchase = $purchase->find($id);
        // dd($purchase->getAmount()*100);
        if(!$purchase) {
            return $this->redirectToRoute("cart_show");
        }
        \Stripe\Stripe::setApiKey('sk_test_51HwK6oJzFZT0NUHQepAZveSRE2Okod51iPZD1RRUZFHU9dXb4Kg7LPYP8OumOTE27kvYDUjDu3mvQDd5heIF4xHe00AFLtlR07');

        $intent = \Stripe\PaymentIntent::create([
            "amount" => $purchase->getAmount()*100,
            "currency" => 'eur'
        ]);

        dd($intent['client_secret']);

        return $this->render("purchase/payment.html.twig",[
            'clientSecret' => $intent->client_secret
        ]);
    }
    
}