<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 * @package Store\BackendBundle\Controller
 */
class CategoryController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){

        // recupère le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère tous les catégories de ma base de données
        $categories = $em->getRepository('StoreBackendBundle:Category')->findAll(); // Nom du Bundle: Nom de l'entité

        // Requête: SELECT * FROM product
        // Je retourne la vue List contenue dans le dossier Category de mon Bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Category:list.html.twig',array(
            'categories' => $categories
        ));
    }

    /**
     * @param $id
     * @param $title
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $title){

        // recupère le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère tous les catégories de ma base de données
        $category = $em->getRepository('StoreBackendBundle:Category')->find($id); // Nom du Bundle: Nom de l'entité


        // je retourne ma vue view de Catégorie où je transmet l'id en vue et le name
        return $this->render('StoreBackendBundle:Category:view.html.twig',
            array(
                'category' => $category, // le nom de ma clé sera le nom de ma variable en vue

            )
        );
    }


    public function removeAction($id){

        // recupere le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère la catégorie dans ma base de données
        $category = $em->getRepository('StoreBackendBundle:Category')->find($id); // Nom du Bundle: Nom de l'entité

        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('store_backend_category_list');
    }



}

