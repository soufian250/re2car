<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Car;
use ProjectBundle\Form\CarType;
use ProjectBundle\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;


class CarController extends Controller
{


    public function indexAction()
    {
        return  $this->render('@Project/Default/index.html.twig');
    }

    public function showAction()
    {


        $cars=$this->getDoctrine()->getRepository(Car::class)->findAll();


        return  $this->render('@Project/Car/show.html.twig',[
            'cars'=>$cars
        ]);
    }

    public function addAction(Request $request)
    {


        $car = new Car();
        $form = $this->createForm(CarType::class,$car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageName = $form->get('imageName')->getData();

          //  $fileUploaderService=$this->container->get('fileuploader.service');

            $originalFilename = pathinfo($imageName->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);

            $newFilename = $originalFilename.'-'.uniqid().'.'.$imageName->guessExtension();

            // Move the file to the directory where brochures are stored

            try {

                $imageName->move(
                    $this->getParameter('car_image_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle Exceptions here
            }

            $car->setImageName($newFilename);
            $car = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('car_show',array('flash'=>'Voiture'));
        }



        return $this->render('@Project/Car/add.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    public function deleteAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $car=$em->getRepository(Car::class)->find($id);
        $em->remove($car);
        $em->flush();
        return $this->redirectToRoute('index_page');

    }

    public function detailAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();

        $car=$em->getRepository(Car::class)->find($id);

        return $this->render('@Project/Car/detail.html.twig', [
            'car' => $car,
        ]);


    }

    public function editAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();

        $car=$em->getRepository(Car::class)->find($id);

        $form = $this->createForm(CarType::class,$car);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $imageName = $form->get('imageName')->getData();
            if ($imageName) {
                $originalFilename = pathinfo($imageName->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageName->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageName->move(
                        $this->getParameter('car_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }


                $car->setImageName($newFilename);
            }


            $car = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('index_page');
        }


        return $this->render('@Project/Car/edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
