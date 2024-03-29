<?php
namespace App\EventSubscriber;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    private $session;
            
    public function __construct(
        EntityManagerInterface $entityManager,
        SessionInterface $session    
    ) {
        $this->entityManager = $entityManager;
        $this->session = $session;
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

        if ($entity->hasRole('ROLE_ADMIN')) {
            $this->session->getFlashBag()->add('error', 'You cannot delete admin users.');
            $event->setResponse(new RedirectResponse('admin'));
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