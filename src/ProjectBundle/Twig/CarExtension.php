<?php

namespace ProjectBundle\Twig;

use Doctrine\ORM\EntityManager;
use ProjectBundle\Entity\Car;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CarExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('carsNumber', array($this, 'carsNumber')),
        );
    }


    public function carsNumber()
    {

        $cars = $this->em->getRepository(Car::class)->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()->getSingleScalarResult();

        return $cars;
    }

}
