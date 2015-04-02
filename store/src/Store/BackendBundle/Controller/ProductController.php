<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProductController
 * @package Store\BackendBundle\Controller
 */
class ProductController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        return $this->render('StoreBackendBundle:Product:list.html.twig');
    }

    /**
     * Page view d'un produit
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){
        return $this->render('StoreBackendBundle:Product:view.html.twig',
            array(
                'id' => $id,
                'name' => $name
            )
        );
    }


}

