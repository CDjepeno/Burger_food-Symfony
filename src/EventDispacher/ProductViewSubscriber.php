<?php
namespace App\EventDispacher;

use App\Event\ProductViewEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;



class ProductViewSubscriber implements EventSubscriberInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
       $this->logger = $logger; 
    }

    public static function  getSubscribedEvents()
    {
        return [
            "product.view" => "writeLogger"
        ];
    }

    public function writeLogger(ProductViewEvent $productViewEvent)
    {
        $this->logger->info("Ecriture dans le log");
    }
}