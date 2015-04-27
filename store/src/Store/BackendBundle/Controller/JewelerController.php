<?php
namespace Store\BackendBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JewelerController extends Controller{

    public function myaccountAction(){

        // recupère le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // je recuper le jeweler connecté
        $user = $this->getUser();

        // Requête: SELECT * FROM product
        // Je retourne la vue myaccount contenue dans le dossier Jeweler de mon Bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Jeweler:myaccount.html.twig',array(
            'jeweler' => $user
        ));
    }
}