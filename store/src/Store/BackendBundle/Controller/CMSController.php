<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CMSController
 * @package Store\BackendBundle\Controller
 */
class CMSController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        return $this->render('StoreBackendBundle:CMS:list.html.twig');
    }

    /**
     * Page view d'une CMS
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){
        // je retourne ma vue view de CMS où je transmet l'id en vue et le name
        return $this->render('StoreBackendBundle:CMS:view.html.twig',
            array(
                'id' => $id, // le nom de ma clé sera le nom de ma variable en vue
                'name' => $name
            )
        );
    }


}

