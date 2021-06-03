<?php
namespace App\EventSubscriber;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityDeletedEvent::class => ['resetUser'],
        ];
    }

    public function resetUser(BeforeEntityDeletedEvent $event){
           
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }

        $query = $this->entityManager->createQuery(
        'SELECT s
        FROM App\Entity\Site s
        WHERE s.user = :id'
        )->setParameter('id', $entity->getId());

        $sites = new ArrayCollection();
        $sites = $query->getResult();

        foreach($sites as $site) {$site->setUser(null);}
    }
}