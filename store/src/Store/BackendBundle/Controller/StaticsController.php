<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 * @package Store\BackendBundle\Controller
 */
class StaticsController extends Controller{
    /**
     * Page Contact
     */
    public function contactAction(){
        // je retourne la vue contact contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:contact.html.twig');
    }

    /**
     * Page About
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction(){
        // je retourne la vue about (à propos) contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:about.html.twig');
    }

    /**
     * Page Terms
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function termsAction(){ // mentionsLegalesAction
        // je retourne la vue terms (des mentions légales) contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:terms.html.twig');
    }

    /**
     * Page Concept
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function conceptAction(){
        // je retourne la vue des concept contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:concept.html.twig');
    }

}