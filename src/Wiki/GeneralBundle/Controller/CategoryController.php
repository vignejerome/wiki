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

         return $this->render('WikiGeneralBundle:Category:createCategory.html.twig', array(
             'form' => $form->createView(),
         ));
     }

    /**
    *
    * Suppression d'une categorie
    *
    * @Route("delete-category/{id}", name="_wiki_deleteCategory")
    * @Template()
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function deleteCategoryAction($id)
    {
      $category = $this->getDoctrine()
        ->getRepository('WikiGeneralBundle:Category')
        ->findOneBy(array('id' => $id));

        if ($category) {
            $em = $this->getDoctrine()->getManager();
            $pages = $category->getPages();
            if ( !empty($pages) ){
                foreach ($pages as $page){
                    $em->remove($page);
                }                
            }
            $em->remove($category);
            $em->flush();
            return $this->render('WikiGeneralBundle:Category:deleteCategory.html.twig', array('category' => $category));
        }else{
          throw $this->createNotFoundException(
                'Aucune category trouvée pour cette url'
            );
        }
    }
}
