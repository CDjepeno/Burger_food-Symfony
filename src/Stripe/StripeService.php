<?php
namespace App\Stripe;

use Stripe\Stripe;
use App\Entity\Purchase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StripeService extends AbstractController
{
    protected $secretKey;
    protected $publicKey;

    public function __construct(string $secretKey, string $publicKey)
    {
        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
    }
    
    public function getPayment(Purchase $purchase)
    {
      \Stripe\Stripe::setApiKey($this->secretKey);

      $session = \Stripe\Checkout\Session::create([
          'payment_method_types' => ['card'],
          'line_items' => [[
            'price_data' => [
              'currency' => 'eur',
              'product_data' => [
                'name' => $purchase->getFullname(),
              ],
              'unit_amount' => $purchase->getAmount()*100,
            ],
            'quantity' => 1,
          ]],
          'mode' => 'payment',
          'success_url' => $this->generateUrl("success",['id'=>$purchase->getId()],UrlGeneratorInterface::ABSOLUTE_URL),
          'cancel_url' => $this->generateUrl("cart_show",[],UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return new JsonResponse([ 'id' => $session->id ]);
    }
}