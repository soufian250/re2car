<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Post;
use ProjectBundle\Form\CarType;
use ProjectBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class BlogController extends Controller
{



    public function showAction()
    {

        $post=$this->getDoctrine()->getRepository(Post::class)->findAll();

        return  $this->render('@Project/Blog/Post/show.html.twig',[
            'post'=>$post
        ]);
    }


    public function addAction(Request $request)
    {


        $post = new Post();

        $form = $this->createForm(PostType::class,$post);

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
                        $this->getParameter('post_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setImageName($newFilename);
            }


            $post = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_list',['flash'=>'Post']);
        }


        return $this->render('@Project/Blog/Post/add.html.twig', [
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

            $imageName = $form->get('imageName')->getData();
            if ($imageName) {
                $originalFilename = pathinfo($imageName->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageName->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageName->move(
                        $this->getParameter('post_image_directory'),
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

    public function listAction()
    {

        $posts=$this->getDoctrine()->getRepository(Post::class)->findAll();

        return  $this->render('@Project/Blog/Post/list.html.twig',[
            'posts'=>$posts
        ]);

    }
}
