<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SupplierController
 * @package Store\BackendBundle\Controller
 */
class SupplierController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){

        // recupère le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        // Je récupère le Repository de mon entité Supplier
        $supplier = $em->getRepository('StoreBackendBundle:Supplier')->getSupplierByUser($user); // Nom du Bundle: Nom de l'entité

        // Requête: SELECT * FROM product
        // Je retourne la vue List contenue dans le dossier Supplier de mon Bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Supplier:list.html.twig',array(
            'supplier' => $supplier
        ));
    }

    /**
     * Page view d'un supplier(fournisseur)
     * @param $id
     * @param $title
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $title){

        // recupère le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère tous les Fournisseurs de ma base de données
        $supplier = $em->getRepository('StoreBackendBundle:Supplier')->find($id); // Nom du Bundle: Nom de l'entité


        // je retourne ma vue view de Fournisseur où je transmet l'id en vue et le name
        return $this->render('StoreBackendBundle:Supplier:view.html.twig',
            array(
                'supplier' => $supplier, // le nom de ma clé sera le nom de ma variable en vue

            )
        );
    }

    public function removeAction($id){

        // recupere le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère le fournisseur dans ma base de données
        $supplier = $em->getRepository('StoreBackendBundle:Supplier')->find($id); // Nom du Bundle: Nom de l'entité

        $em->remove($supplier);
        $em->flush();

        return $this->redirectToRoute('store_backend_supplier_list');
    }


}

