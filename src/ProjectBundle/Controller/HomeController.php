<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{

    public function indexAction()
    {
        return  $this->render('@Project/Home/index.html.twig');
    }


    public function storeAction()
    {
        return  $this->render('@Project/Home/store.html.twig');
    }


    public function aboutAction()
    {
        return  $this->render('@Project/Home/about.html.twig');
    }


    public function contactAction()
    {
        return  $this->render('@Project/Home/contact.html.twig');
    }
}
