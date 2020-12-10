<?php
namespace App\purchase;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;


class PurchasePersister 
{
    protected $security;
    protected $cartService;
    protected $manager;

    public function __construct(Security $security, CartService $cartService, EntityManagerInterface $manager)
    {
        $this->cartService = $cartService;
        $this->security    = $security;
        $this->manager     = $manager;
    }

    public function storePurchase(Purchase $purchase)
    {
        $purchase->setCustomer($this->security->getUser())
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
    }
}