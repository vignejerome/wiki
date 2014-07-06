<?php

namespace Wiki\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Wiki\GeneralBundle\Entity\Page;
use Wiki\GeneralBundle\Entity\Category;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction($name)
    {
        return $this->render('WikiGeneralBundle:Default:index.html.twig', array('name' => $name));
    }

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
        return $this->render('WikiGeneralBundle:Default:page.html.twig', array('page' => $page));
    }


   /**
    * Création d'une page
    *
    * @Route("/create-page", name="_wiki_createPage")
    * @Template()
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

        return $this->render('WikiGeneralBundle:Default:createPage.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * Méthode retournant une page
     *
     * @param $page_id
     */
    public function getPageAction($page_id)
    {
        $page = $this->getDoctrine()
        ->getRepository('WikiGeneralBundle:page')
        ->find($page_id);

        return new Response('La page : '.$page->getTitle());
    }
}
