<?php

namespace ProjectBundle\ApiRestController;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Client;
use ProjectBundle\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRestProjectController extends FOSRestController
{

    /**
     * @Rest\Get("/car/delete")
     */

    public function deleteCarAction(Request $request)
    {

        $idCar = $request->query->get('idCar');
        $em=$this->getDoctrine()->getManager();
        $car=$em->getRepository(Car::class)->find($idCar);
        $em->remove($car);
        $em->flush();

        $response = new Response(json_encode(['status'=>'OK']));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Rest\Get("/client/delete")
     */

    public function deleteClientAction(Request $request)
    {

        $idClient = $request->query->get('idClient');

        $em=$this->getDoctrine()->getManager();
        $client=$em->getRepository(Client::class)->find($idClient);
        $em->remove($client);
        $em->flush();

        $response = new Response(json_encode(['status'=>'OK']));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Rest\GET("/reservation/add/date")
     */

    public function addReservationAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();

        $form = $request->query->get('from');
        $to = $request->query->get('to');
        $daysNumber = $request->query->get('daysNumber');
        $formTime = $request->query->get('startTime');
        $toTime = $request->query->get('endTime');
        $selectedUser = $request->query->get('selectedUser');
        $selectedCar = $request->query->get('selectedCar');


        $dateFrom = new \DateTime($form);
        $dateTo = new \DateTime($to);


        $arrFrom = array_map('intval', explode(':', $formTime));
        $time = mktime($arrFrom[0], $arrFrom[1], 1, date('m'), date('d'), date('Y'));

        $arrTo = array_map('intval', explode(':', $toTime));
        $time2 = mktime($arrTo[0], $arrTo[1], 1, date('m'), date('d'), date('Y'));

        $timeFrom = date("m/d/Y h:i:s A T",$time);
        $timeTo = date("m/d/Y h:i:s A T",$time2);

        $test = new \DateTime($timeFrom);
        $test2 = new \DateTime($timeTo);

        $client = $this->getDoctrine()->getRepository(Client::class)->find(intval($selectedUser));
        $car = $this->getDoctrine()->getRepository(Car::class)->find(intval($selectedCar));

        if ($client != null)
            $client->setReservationNumber($client->getReservationNumber() + 1);
        else
            $client->setReservationNumber(1);

        $rentAmount = $car->getRentAmount();

        $reservation = new Reservation();

        $client->setStatusReservation(true);
        $car->setStatusReservation(true);
        $reservation->setStatusReservation(true);

        $reservation->setStartDate($dateFrom);
        $reservation->setEndDate($dateTo);
        $reservation->setStartTime($test);
        $reservation->setEndTime($test2);
        $reservation->setClient($client);
        $reservation->setDaysNumber(intval($daysNumber));

        $reservation->setAmountTotal(intval($daysNumber) *floatval($rentAmount));
        $reservation->setCar($car);

        $em->persist($reservation);
        $em->flush();

        $response = new Response(json_encode(['link'=> 'ok']));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Get("/reservation/delete")
     */

    public function deleteReservationAction(Request $request)
    {

        $idReservation = $request->query->get('idReservation');
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository(Reservation::class)->find($idReservation);
        $reservation->getCar()->setStatusReservation(false);
        $em->remove($reservation);
        $em->flush();

        $response = new Response(json_encode(['status'=>'Delete OK']));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Rest\GET("/home/search")
     */

    public function searchAction(Request $request)
    {


        $em=$this->getDoctrine()->getManager();

        $form = $request->query->get('from');
        $to = $request->query->get('to');


        $cars = $em->getRepository(Car::class)
                ->createQueryBuilder('c')
                ->where('c.statusReservation = :statusReservation')
                ->setParameter('statusReservation',false)
                ->getQuery()->getResult();



        $response = new Response(json_encode(['cars'=>$cars]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }



}