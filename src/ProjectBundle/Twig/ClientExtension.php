<?php

namespace ProjectBundle\Twig;

use Doctrine\ORM\EntityManager;
use ProjectBundle\Entity\Client;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ClientExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('clientCount', array($this, 'clientCount')),
        );
    }


    public function clientCount()
    {

        $cars = $this->em->getRepository(Client::class)->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()->getSingleScalarResult();

        return $cars;
    }

}
