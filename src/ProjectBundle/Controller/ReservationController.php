<?php

namespace ProjectBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Reservation;
use ProjectBundle\Form\CarType;
use ProjectBundle\Form\ReservationType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReservationController extends Controller
{



    public function indexAction()
    {
        return  $this->render('@Project/Default/index.html.twig');
    }

    public function showAction()
    {

        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findAll();

        return  $this->render('@Project/Reservation/show.html.twig',[
            'reservations'=> $reservation

            ]
        );
    }

    public function addAction(Request $request)
    {


        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $reservation = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_show',array('flash'=>'Reservation'));

        }


        return $this->render('@Project/Reservation/add.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    public function detailAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $car=$em->getRepository(Reservation::class)->find($id);

        return $this->render('@Project/Reservation/detail.html.twig', [
            'car' => $car,
        ]);

    }
}
