<?php

namespace ProjectBundle\Twig;

use Doctrine\ORM\EntityManager;
use ProjectBundle\Entity\Reservation;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ReservationExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('reservationCount', array($this, 'reservationCount')),
        );
    }


    public function reservationCount()
    {

        $reservation = $this->em->getRepository(Reservation::class)->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery()->getSingleScalarResult();


        return $reservation;
    }

}
