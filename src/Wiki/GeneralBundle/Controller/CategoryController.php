<?php

namespace Wiki\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Wiki\GeneralBundle\Entity\Category;

class CategoryController extends Controller
{

  /**
   * Affichage les categories avec les pages associés
   *
   */
    public function showCategoryWithPageAction()
    {
        $categorys = $this->getDoctrine()
        ->getRepository('WikiGeneralBundle:Category')
        ->findAll();

        if (!$categorys) {
            throw $this->createNotFoundException(
                'Aucune Category trouvée'
            );
        }
        return $this->render('WikiGeneralBundle:Category:sidebar.html.twig', array('categorys' => $categorys));
    }
}
