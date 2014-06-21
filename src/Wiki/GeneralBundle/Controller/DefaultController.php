<?php

namespace Wiki\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WikiGeneralBundle:Default:index.html.twig', array('name' => $name));
    }

    public function pageAction()
    {
        $title = "title";
        $body = "body";
        return $this->render('WikiGeneralBundle:Default:page.html.twig', array('title' => $title, 'body' => $body));
    }
}
