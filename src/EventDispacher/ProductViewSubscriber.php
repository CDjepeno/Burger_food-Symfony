<?php
namespace App\EventDispacher;

use Psr\Log\LoggerInterface;
use App\Event\ProductViewEvent;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;



class ProductViewSubscriber implements EventSubscriberInterface
{
    protected $logger;
    
    protected $mailer;   
    
    public function __construct(LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger; 
        $this->mailer = $mailer;
    }

    public static function  getSubscribedEvents()
    {
        return [
            "product.view" => "sendEmail"
        ];
    }

    public function sendEmail(ProductViewEvent $productViewEvent)
    {
        // $email = new TemplatedEmail();
        // $email->from(new Address("Contact@gmail.com", "info de la boutique"))
        //       ->to("admin@mail.com")
        //       ->text("Un visiteur est en train de voir la page du produit")
        //       ->htmlTemplate("email/product_view.html.twig")
        //       ->context([
        //           "product" => $productViewEvent->getProduct()
        //       ])
        //       ->subject("Visite du produit");

        // $this->mailer->send($email);
    }
}