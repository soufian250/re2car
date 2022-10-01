<?php

namespace HomeBundle\Controller;

use ProjectBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HomeBundle:Index:index.html.twig');
    }

    public function CarsListingAction()
    {

        $em=$this->getDoctrine()->getManager();

        $cars = $em->getRepository(Car::class)->findAll();


        return $this->render('HomeBundle:CarsListing:cars_listing.html.twig',[
            'cars'=>$cars
        ]);
    }
}
