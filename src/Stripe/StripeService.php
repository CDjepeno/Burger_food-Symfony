<?php
namespace App\Stripe;

use Stripe\Stripe;
use App\Entity\Purchase;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class StripeService extends AbstractController
{
    protected $secretKey;
    protected $publicKey;

    public function __construct(string $secretKey, string $publicKey)
    {
        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
    }
    
    
    public function getPaymentIntent(Purchase $purchase)
    {

        \Stripe\Stripe::setApiKey($this->secretKey);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                  'name' => 'voiture',
                ],
                'unit_amount' => $purchase->getAmount()*100,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl("purchase_payement_success",['id'=>$purchase->getId()],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl("error",[],UrlGeneratorInterface::ABSOLUTE_URL),
          ]);

          return new JsonResponse([ 'id' => $session->id ]);
          
        // return \Stripe\PaymentIntent::create([
        //     "amount" => $purchase->getAmount()*100,
        //     "currency" => 'eur'
        // ]);
    }
}