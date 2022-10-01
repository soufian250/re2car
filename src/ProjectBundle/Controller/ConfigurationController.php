<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Configuration;
use ProjectBundle\Entity\Post;
use ProjectBundle\Form\CarType;
use ProjectBundle\Form\ConfigurationType;
use ProjectBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ConfigurationController extends Controller
{



    public function showAction()
    {

        $post=$this->getDoctrine()->getRepository(Post::class)->findAll();

        return  $this->render('@Project/Configuration/Post/show.html.twig',[
            'post'=>$post
        ]);
    }


    public function addAction(Request $request)
    {


        $configuration = new Configuration();

        $form = $this->createForm(ConfigurationType::class,$configuration);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $configuration = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($configuration);
            $entityManager->flush();

            return $this->redirectToRoute('post_list',['flash'=>'Post']);
        }


        return $this->render('@Project/Configuration/add.html.twig', [
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

    public function editAction(Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();

        $car=$em->getRepository(Post::class)->find($id);

        $form = $this->createForm(PostType::class,$car);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $car = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('index_page');
        }


        return $this->render('@Project/Configuration/edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function listAction()
    {

        $posts=$this->getDoctrine()->getRepository(Post::class)->findAll();

        return  $this->render('@Project/Configuration/Post/list.html.twig',[
            'posts'=>$posts
        ]);

    }
}
