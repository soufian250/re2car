<?php


namespace ProjectBundle\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use ProjectBundle\Entity\AuditLog;
use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Client;
use ProjectBundle\Entity\Model;
use ProjectBundle\Entity\Post;
use ProjectBundle\Entity\Reservation;
use ProjectBundle\Entity\Type;
use Symfony\Component\Security\Core\Security;

class GlobalListener implements EventSubscriber
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     * @return array
     */
    public function getSubscribedEvents()
        {
            return [
                Events::postPersist,
                Events::postRemove,
                Events::postUpdate,
            ];
        }



    public function postPersist(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();
        $em = $args->getEntityManager();
        $auditLog = new AuditLog();

        if ($entity instanceof Car || $entity instanceof Client || $entity instanceof Model || $entity instanceof Post || $entity instanceof Reservation || $entity instanceof Type) {


            $user = $this->security->getUser();
            $dateActivity = new \DateTime('now');
            $auditLog->setActivity('add');
            $auditLog->setEntity($entity->getThisClass());
            $auditLog->setDateActivity($dateActivity);
            $auditLog->setUser($user);
            $em->persist($auditLog);
            $em->flush();
        }

    }


    public function postUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();
        $em = $args->getEntityManager();
        $auditLog = new AuditLog();

        if ($entity instanceof Car || $entity instanceof Client || $entity instanceof Model || $entity instanceof Post || $entity instanceof Reservation || $entity instanceof Type) {


            $user = $this->security->getUser();
            $dateActivity = new \DateTime('now');
            $auditLog->setActivity('update');
            $auditLog->setEntity($entity->getThisClass());
            $auditLog->setDateActivity($dateActivity);
            $auditLog->setUser($user);
            $em->persist($auditLog);
            $em->flush();
        }

    }


    public function postRemove(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();
        $em = $args->getEntityManager();
        $auditLog = new AuditLog();

        if ($entity instanceof Car || $entity instanceof Client || $entity instanceof Model || $entity instanceof Post || $entity instanceof Reservation || $entity instanceof Type) {


            $user = $this->security->getUser();
            $dateActivity = new \DateTime('now');
            $auditLog->setActivity('remove');
            $auditLog->setEntity($entity->getThisClass());
            $auditLog->setDateActivity($dateActivity);
            $auditLog->setUser($user);
            $em->persist($auditLog);
            $em->flush();
        }

    }


}