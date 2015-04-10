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

        // recupere le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère tous les produits de jeweler numéro 1
        $products = $em->getRepository('StoreBackendBundle:Product')->getProductByUser(1); // Nom du Bundle: Nom de l'entité

        // Requête: SELECT * FROM product
        // Je retourne la vue List contenue dans le dossier Product de mon Bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Product:list.html.twig',array(
            'products' => $products
        ));

    }

    /**
     * @param $id
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $slug){

        // recupere le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère le produit de ma base de données
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id); // Nom du Bundle: Nom de l'entité

        return $this->render('StoreBackendBundle:Product:view.html.twig',
            array(
                'product' => $product
            )
        );
    }

    public function removeAction($id){

        // recupere le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère le produit de ma base de données
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id); // Nom du Bundle: Nom de l'entité

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('store_backend_product_list');
    }


}

