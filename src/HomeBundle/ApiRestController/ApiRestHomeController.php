<?php

namespace HomeBundle\ApiRestController;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRestHomeController extends FOSRestController
{

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

}