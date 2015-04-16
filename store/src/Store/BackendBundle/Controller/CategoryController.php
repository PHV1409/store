<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Form\CategoryType;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $categories = $em->getRepository('StoreBackendBundle:Category')->getCategoryByUser(1); // Nom du Bundle: Nom de l'entité

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

    public function newAction(Request $request){
        $category = new Category();

        $em = $this->getDoctrine()->getManager();
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1); // je récupère le jeweler num 1
        $category->setJeweler($jeweler); // J'associe mon jeweler à ma catégorie
        $form = $this->createForm(new CategoryType(), $category, array(
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate', // pour virer la validation html5
                'action' => $this->generateUrl('store_backend_category_new')
            )
        ));
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('store_backend_category_list');
        }

        return $this->render('StoreBackendBundle:Category:new.html.twig',
            array('form' => $form->createView())
        );

    }


}

