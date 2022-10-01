<?php

namespace HomeBundle\Controller;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
//use Nette\Application\Request;
use ProjectBundle\Entity\Car;
use ProjectBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

use HomeBundle\Entity\Contact;

class HomeController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cars =$em->getRepository('ProjectBundle:Car')->createQueryBuilder('c')->setMaxResults(6)->getQuery()->getResult();
        return  $this->render('@Home/Home/index.html.twig' ,['cars'=>$cars]);


    }


    public function storeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeReservations = $em->getRepository('ProjectBundle:Car')->findAll();
        $cars  = $this->get('knp_paginator')->paginate($listeReservations,$request->query->get('page', 1), 6);
        return  $this->render('@Home/Home/store.html.twig',['cars'=>$cars]);
    }


    public function aboutAction()
    {
        return  $this->render('@Home/Home/about.html.twig');
    }

    public function CarDetailAction()
    {
        return  $this->render('@Home/Home/detail_car.html.twig');
    }



    public function contactAction(Request $request)
    {
        $contact = new Contact;     
     # Add form fields


       $form = $this->createFormBuilder($contact)
       ->add('name', TextType::class, array('label'=> 'name', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
       ->add('email', EmailType::class, array('label'=> 'email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
       ->add('subject', TextType::class, array('label'=> 'subject','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
       ->add('message', TextareaType::class, array('label'=> 'message','attr' => array('rows'=>'10','class' => 'form-control')))
       ->add('Save', SubmitType::class, array('label'=> 'Envoyer', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:15px')))
       ->getForm();


     # Handle form response
       $form->handleRequest($request);

       if($form->isSubmitted() &&  $form->isValid()){

            $name = $form['name']->getData();
            $email = $form['email']->getData();
            $subject = $form['subject']->getData();
            $message = $form['message']->getData();
             # set form data
            $contact->setName($name);
            $contact->setEmail($email);
            $contact->setSubject($subject);
            $contact->setMessage($message);
            # finally add data in database
            $sn = $this->getDoctrine()->getManager();
            $sn -> persist($contact);
            $sn -> flush();


           return $this->redirectToRoute('contact',['flash'=>'Message/envoye/avec/success']);
       }
        return  $this->render('@Home/Home/contact.html.twig',['form' => $form->createView()]);
    }



    public function blogAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listePosts = $em->getRepository('ProjectBundle:Post')->findByPublished(1);
        $posts  = $this->get('knp_paginator')->paginate($listePosts,$request->query->get('page', 1), 6);
        return  $this->render('@Home/Home/blog.html.twig',['posts'=>$posts]);
    }

    /**
     * @Route("/blog/{id}", name="singleBlog")
     */
    public function singleBlogAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('ProjectBundle:Post')->find($id);
        return  $this->render('@Home/Home/singleblog.html.twig',['post'=>$post]);
    }

    /**
     * @Route("/terms", name="terms")
     */
    public function termsAction()
    {

        return  $this->render('@Home/Home/terms.html.twig');
    }


    /**
     * @Route("/search", name="search")
     */
    public function searchAction()
    {
        return  $this->render('@Home/Home/search_result.html.twig');
    }
}
