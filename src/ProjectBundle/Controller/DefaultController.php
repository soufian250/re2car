<?php

namespace ProjectBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;

class DefaultController extends Controller
{



    public function indexAction()
    {
        return  $this->render('@Project/Default/index.html.twig');
    }

    public function userProfileAction()
    {

        $user = $this->getUser();

        return  $this->render('@Project/Default/user_profile.html.twig',compact('user'));
    }
}
