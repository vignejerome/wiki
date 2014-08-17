<?php

namespace Wiki\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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

    /**
     * Création d'une categorie
     *
     * @Route("create-category", name="_wiki_createCategory")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
     public function createCategoryAction()
     {
         $category = new Category();
         $form = $this->createForm('category', $category);

         // On récupère la requête
         $request = $this->get('request');
         // On vérifie qu'elle est de type POST
         if ($request->getMethod() == 'POST') {
           // On fait le lien Requête <-> Formulaire
           // À partir de maintenant, la variable $page contient les valeurs entrées dans le formulaire par le visiteur
           $form->bind($request);
           // On vérifie que les valeurs entrées sont correctes
           // (Nous verrons la validation des objets en détail dans le prochain chapitre)
           if ($form->isValid()) {
             // On l'enregistre notre objet $page dans la base de données
             $em = $this->getDoctrine()->getManager();
             $em->persist($category);
             $em->flush();
             // On redirige vers la page de visualisation de l'article nouvellement créé
             return $this->redirect($this->generateUrl('_wiki_createPage'));
           }
         }

         return $this->render('WikiGeneralBundle:Default:createCategory.html.twig', array(
             'form' => $form->createView(),
         ));
     }
}
