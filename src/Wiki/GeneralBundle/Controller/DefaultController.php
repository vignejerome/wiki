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


    /**
     * Méthode de création d'une page
     *
     * @param $category_id identifiant de la category
     * @param $title titre de la page
     * @param $body texte de la page
     */
    public function createPageAction($category_id, $title, $body)
    {
        $category = $this->getDoctrine()
        ->getRepository('WikiGeneralBundle:Category')
        ->find($category_id);

        $page = new Page();
        $page->setTitle($title);
        $page->setBody($body);
        // lie ce produit à une catégorie
        $page->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($page);
        $em->flush();

        return new Response('La page : '.$page->getTitle().' a été créée dans la catégorie : '.$category->getName());
    }
}
