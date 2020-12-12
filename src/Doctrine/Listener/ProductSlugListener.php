<?php
namespace App\Doctrine\Listener;

use App\Entity\Product;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Event\LifecycleEventArgs as EventLifecycleEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ProductSlugListener 
{
    public function prePersist(Product $entity, EventLifecycleEventArgs $event)
    {
        if (empty($entity->getSlug())) {
            $slugify = new Slugify();
            $entity->setSlug($slugify->slugify(strtolower($entity->getName())));
        }
    }
}