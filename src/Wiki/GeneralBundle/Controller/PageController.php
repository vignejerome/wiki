<?php

namespace Wiki\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Wiki\GeneralBundle\Entity\Page;
use Wiki\GeneralBundle\Entity\Category;

class PageController extends Controller
{

    /**
     * Affichage de la page
     *
     * @Route("/page/{slug}", name="_wiki_page")
     * @Template()
     */
    public function pageAction($slug)
    {
        $page = $this->getDoctrine()
        ->getRepository('WikiGeneralBundle:Page')
        ->findOneBy(array('slug' => $slug));

        if (!$page) {
            throw $this->createNotFoundException(
                'Aucune page trouvée pour cette url'
            );
        }
        return $this->render('WikiGeneralBundle:Page:page.html.twig', array('page' => $page));
    }


   /**
    * Création d'une page
    *
    * @Route("create-page", name="_wiki_createPage")
    * @Template()
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function createPageAction()
    {
        $page = new Page();
        $form = $this->createForm('page', $page);

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
            $em->persist($page);
            $em->flush();
            // On redirige vers la page de visualisation de l'article nouvellement créé
            return $this->redirect($this->generateUrl('_wiki_page', array('slug' => $page->getSlug())));
          }
        }

        return $this->render('WikiGeneralBundle:Page:createPage.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
    * Mise a jour d'une page
    *
    * @Route("update-page/{id}", name="_wiki_updatePage")
    * @Template()
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function updatePageAction($id)
    {
        $page = new Page();
        
        $page = $this->getDoctrine()
        ->getRepository('WikiGeneralBundle:Page')
        ->findOneBy(array('id' => $id));

        $form = $this->createForm('page', $page);

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
            // On met a jour notre objet $page dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            // On redirige vers la page de visualisation de la page nouvellement modifié
            return $this->redirect($this->generateUrl('_wiki_page', array('slug' => $page->getSlug())));
          }
        }

        return $this->render('WikiGeneralBundle:Page:updatePage.html.twig', array(
            'form' => $form->createView(), 'id' => $page->getId(),
        ));
    }

    /**
    * Suppression d'une page
    *
    * @Route("delete-page/{id}", name="_wiki_deletePage")
    * @Template()
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function deletePageAction($id)
    {
      $page = $this->getDoctrine()
        ->getRepository('WikiGeneralBundle:Page')
        ->findOneBy(array('id' => $id));

        if ($page) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();

            return $this->render('WikiGeneralBundle:Page:deletePage.html.twig', array('page' => $page));
        }else{
          throw $this->createNotFoundException(
                'Aucune page trouvée pour cette url'
            );
        }
    }
}
