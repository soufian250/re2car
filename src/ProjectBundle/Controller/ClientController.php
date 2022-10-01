<?php

namespace ProjectBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ProjectBundle\Entity\Client;
use ProjectBundle\Entity\Reservation;
use ProjectBundle\Form\ClientType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ClientController extends Controller
{


    public function indexAction()
    {
        return  $this->render('@Project/Default/index.html.twig');
    }

    public function reservationAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservations=$em->getRepository(Reservation::class)->createQueryBuilder('r')
                        ->leftJoin('r.client','c')
                        ->where('c.id = :id')
                        ->setParameter('id',$id)
                        ->getQuery()
                        ->getResult();


        $user = $em->getRepository(Client::class)->find($id);

        return  $this->render('@Project/Reservation/user_reservation.html.twig',[
            'reservations'=>$reservations,
            'user'=>$user
        ]);
    }

    public function showAction()
    {

        $client = $this->getDoctrine()->getRepository(Client::class)->findAll();


        return  $this->render('@Project/Client/show.html.twig',[
            'clients'=>$client
        ]);
    }

    public function addAction(Request $request)
    {


        $client = new Client();

        $form = $this->createForm(ClientType::class,$client);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

//            $imageName = $form->get('imageName')->getData();
//            if ($imageName) {
//                $originalFilename = pathinfo($imageName->getClientOriginalName(), PATHINFO_FILENAME);
//                // this is needed to safely include the file name as part of the URL
//               // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
//                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageName->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                try {
//                    $imageName->move(
//                        $this->getParameter('client_image_directory'),
//                        $newFilename
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//
//                // updates the 'brochureFilename' property to store the PDF file name
//                // instead of its contents
//                $client->setImageName($newFilename);
//            }


            $client = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_show',array('flash'=>'client'));
        }


        return $this->render('@Project/Client/add.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    public function deleteAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $client=$em->getRepository(Client::class)->find($id);

        $em->remove($client);
        $em->flush();
        return $this->redirectToRoute('index_page');

    }

    public function editAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();

        $client=$em->getRepository(Client::class)->find($id);


        $form = $this->createForm(ClientType::class,$client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $imageName = $form->get('imageName')->getData();
//            if ($imageName) {
//                $originalFilename = pathinfo($imageName->getClientOriginalName(), PATHINFO_FILENAME);
//                // this is needed to safely include the file name as part of the URL
//                // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
//                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageName->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                try {
//                    $imageName->move(
//                        $this->getParameter('car_image_directory'),
//                        $newFilename
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//
//
//                $client->setImageName($newFilename);
//            }


            $client = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('index_page');
        }


        return $this->render('@Project/Client/edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
