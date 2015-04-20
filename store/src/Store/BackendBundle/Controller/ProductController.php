<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Store\BackendBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * Page création d'un produit
     * Je récupère l'objet Request qui contient toutes mes données en GET, POST ...
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){

        // je crée un nouvel objet Product
        // a chaque fois que je crée un objet d'une class, je dois user la classe
        $product = new Product();

        $em = $this->getDoctrine()->getManager(); // Je récupère le manager de Doctrine
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1); // je récupère le jeweler num 1
        $product->setJeweler($jeweler); // J'associe mon jeweler à mon produit

        // j'initialise la quantité et le prix de mon produit
        // sauf si déjà initialisé dans mon constructeur de l'Entity
        // $product->setQuantity(0);
        // $product->setPrice(0);

        // je crée un formulaire de produit$
        $form = $this->createForm(new ProductType(1), $product, array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate', // pour virer la validation html5
                'action' => $this->generateUrl('store_backend_product_new')
                // l'Url de la route new
                // action de formulaire pointe vers cette même action de controller
            )
        ));

        // Je fusionne ma requête avec mon formulaire
        $form->handleRequest($request);

        // si la totalité du formulaire est valide
        if($form->isValid()){

            // j'upload mon fichier en faisant appel à la méthode upload si mon formulaire est valide
            $product->upload();

            //exit('YES ! Mon formulaire est valide :)');
            $em = $this->getDoctrine()->getManager(); // je récupère le manager de Doctrine
            $em->persist($product); // j'enregistre mon objet product dans doctrine
            $em->flush(); // j'envoie ma requête d'insert à ma table product

            // je crée un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre produit a bien été créé.'
            );
            // je récupère la quantité du produit enregistré
            $quantity = $product->getQuantity();

            if($quantity == 1 ){
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    'Votre bijoux est un produit unique !'
                );
            }

            return $this->redirectToRoute('store_backend_product_list'); // redirection selon la route

        }

        // la méthode createView() est utilisée pour renvoyer la d'un formulaire
        return $this->render('StoreBackendBundle:Product:new.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Product $id){

        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);

        $form = $this->createForm(new ProductType(1), $id, array(
            'validation_groups' => 'edit',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_product_edit',
                        array('id' => $id->getId())
                )
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

            return $this->redirectToRoute('store_backend_product_list');

        }

        return $this->render('StoreBackendBundle:Product:edit.html.twig',
            array('form' => $form->createView())
        );
    }



}

