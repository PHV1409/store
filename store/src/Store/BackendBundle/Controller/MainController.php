<?php

// l'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 * @package Store\BackendBundle\Controller
 */
class MainController extends Controller{
    /**
     * Dashboard on Backend
     */
    public function indexAction(){

        return $this->render('StoreBackendBundle:Main:index.html.twig');
    }

}