<?php

namespace ProjectBundle\Twig;

use Doctrine\ORM\EntityManager;
use HomeBundle\Entity\Contact;
use ProjectBundle\Entity\AuditLog;
use ProjectBundle\Entity\Car;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class GlobalExtension extends \Twig_Extension
{
    protected $em;

    public function __construct(EntityManager $entityManager) {

        $this->em = $entityManager;
    }



    public function getFunctions() {

        $array = [
            'is_safe' => ['html'],
            'needs_environment' => true
        ];



        return array(
            new \Twig_SimpleFunction('notification', array($this, 'notification')),
            new \Twig_SimpleFunction('MessageNotification', array($this, 'MessageNotification')),
            new \Twig_SimpleFunction('AuditLog', array($this, 'AuditLog')),
        );
    }


    public function notification()
    {

        $contact = $this->em->getRepository(Contact::class)->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.seen = :seen')
            ->orWhere('c.seen IS NULL')
            ->setParameter('seen',false)
            ->getQuery()->getSingleScalarResult();

        if ($contact > 9) $contact = '+9';
        return $contact;
    }

    public function MessageNotification()
    {

        $contact = $this->em->getRepository(Contact::class)->createQueryBuilder('c')
            ->where('c.seen = :seen')
            ->orWhere('c.seen IS NULL')
            ->setParameter('seen',false)
            ->getQuery()->getResult();

        return $contact;
    }


  public function AuditLog()
    {

        $auditLog = $this->em->getRepository(AuditLog::class)->createQueryBuilder('a')
            ->orderBy('a.dateActivity','desc')
            ->setMaxResults(4)
            ->getQuery()->getResult();

        return $auditLog;
    }

}
