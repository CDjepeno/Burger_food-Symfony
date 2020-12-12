<?php
namespace App\EventDispacher;

use App\Entity\Customer;
use Psr\Log\LoggerInterface;
use App\Event\PurchaseSuccessEvent;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PurchaseSuccessEmailSubscriber implements EventSubscriberInterface 
{
    protected $logger;
    protected $mailer; 
    protected $security;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer, Security $security)
    {
        $this->logger   = $logger;
        $this->mailer   = $mailer;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            "purchase.success" => "sendSuccessEmail"
        ];
    }

    public function sendSuccessEmail(PurchaseSuccessEvent $purchaseSuccessEvent)
    {
        // 1. Recuperer l'utilisateur
        /** @var Customer */
        $currentUser = $this->security->getUser();
        
        // 2. Recuperer la commande
        $purchase = $purchaseSuccessEvent->getPurchase();

        // 3. écrire le mail
        $email = new TemplatedEmail();
        $email->to(new Address($currentUser->getEmail(), $currentUser->getUsername()))
              ->from("contact@mail.com")
              ->subject("Votre commande ({$purchase->getId()}) a bien été confirmée")
              ->htmlTemplate("email/purchase_success.html.twig")
              ->context([
                  "purchase" => $purchase,
                  "user"     => $currentUser
              ]);

        // 4. Envoyer le mail
        $this->mailer->send($email);
        $this->logger->info("Email envoyé pour la commande n° ". $purchaseSuccessEvent->getpurchase()->getId());
    }
}