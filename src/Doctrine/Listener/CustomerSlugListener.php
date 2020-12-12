<?php

namespace App\Doctrine\Listener;

use App\Entity\Customer;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Event\LifecycleEventArgs as EventLifecycleEventArgs;

class CustomerSlugListener 
{
    public function prePersist(Customer $entity, EventLifecycleEventArgs $event)
    {
        if (empty($entity->getSlug())) {
            $slugify = new Slugify();
            $entity->setSlug($slugify->slugify(strtolower($entity->getUsername())));
        }

        if($entity->getRoles() === null){
            $entity->setRoles("ROLE_USER");
        }
    }
}