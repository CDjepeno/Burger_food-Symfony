<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentSuccessController extends AbstractController
{
    /**
     * Permet de valider un paiement
     *
     * @Route("/purchase/terminate/{id}", name="purchase_payement_success")
     * @IsGranted("ROLE_USER");
     * 
     * @return Response
     */
    public function success($id, PurchaseRepository $purchaseRepository, EntityManagerInterface $em, CartService $cartService)
    {
        // 1. Je récupère la commande
        $purchase = $purchaseRepository->find($id);

        if(
            !$purchase ||
            ($purchase && $purchase->getCustomer() !== $this->getUser()) ||
            ($purchase && $purchase->getCustomer() === Purchase::STATUS_PAID) 
          ){
                $this->addFlash(
                    "warning",
                    "La commande n'existe pas"
                );
                return $this->redirectToRoute("purchase_index");
            }
        // 2. Je fait passer au status PAYEE (PAID)
        $purchase->setStatus(Purchase::STATUS_PAID);
        $em->flush();
        // 3. Je vide le panier

        $cartService->empty();

        // 4. Je redirige avec un flash vers la liste des commandes
        $this->addFlash(
            "success",
            "La commande a été payé et confirmée !"
        );

        return $this->redirectToRoute("purchase_index");
    }
}