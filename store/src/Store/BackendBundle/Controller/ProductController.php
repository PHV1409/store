<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Store\BackendBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
// pour restreindre l'accès à la page pour le role ROLE_COMMERCIAL

/**
 *
 * Nous pouvons utiliser la méthode 2 à ce niveau pour l'ensemble de la class
 * mais il est préférable de le gérer (pour toute la class) dans security.yml
 *
 * Class ProductController
 * @package Store\BackendBundle\Controller
 */
class ProductController extends Controller{

    /**
     * Méthode numéro 2
     * a le role commercial
     * @Security("has_role('ROLE_COMMERCIAL')")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function listAction(){

        // Méthode numéro 1 : restreindre l'accès au niveau de mon action de controller
        // restreindre l'accès au niveau de ma méthode de controller
//        if(false === $this->get('security.conext')->isGranted('ROLE_COMMERCIAL')){
//            throw new AccessDeniedException("Accès interdit pour ce type de contenu");
//        }

        // recupere le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        // Je récupère tous les produits de jeweler numéro 1
        $products = $em->getRepository('StoreBackendBundle:Product')->getProductByUser($user); // Nom du Bundle: Nom de l'entité

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

        $user = $this->getUser();

        $product->setJeweler($user); // J'associe mon jeweler à mon produit

        // j'initialise la quantité et le prix de mon produit
        // sauf si déjà initialisé dans mon constructeur de l'Entity
        // $product->setQuantity(0);
        // $product->setPrice(0);

        // je crée un formulaire de produit$
        $form = $this->createForm(new ProductType($user), $product, array(
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


//            // si ma quantité de produit est inférieur à 5
//            if($quantity < 5){
//                // $this->get() => accède au conteneur du service
//                // la methode notify sera exécuté avec un message
//                $this->get('store.backend.notification')
//                    ->notify($product->getId(),
//                        "La quantité du produit ".$product->getTitle()." est faible",
//                        "product",
//                        "warning"
//                    );
//
//            }
//
//            // si ma quantité de produit est inférieur à 5
//            if($id->getQuantity() == 1){
//                // $this->get() => accède au conteneur du service
//                // la methode notify sera exécuté avec un message
//                $this->get('store.backend.notification')
//                    ->notify($id->getId(),
//                        "Encore une vente et votre produit ".$id->getTitle()." est épuisé.",
//                        "product",
//                        "danger"
//                    );
//            }

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

        $user = $this->getUser();

        $form = $this->createForm(new ProductType($user), $id, array(
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
            $id->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

//            // si ma quantité de produit est inférieur à 5
//            if($id->getQuantity() == 1){
//                // $this->get() => accède au conteneur du service
//                // la methode notify sera exécuté avec un message
//                $this->get('store.backend.notification')
//                    ->notify($id->getId(),
//                        "Encore une vente et votre produit ".$id->getTitle()." est épuisé.",
//                        "product",
//                        "danger"
//                    );
//            }
//            // si ma quantité de produit est inférieur à 5
//            elseif($id->getQuantity() < 5){
//                // $this->get() => accède au conteneur du service
//                // la methode notify sera exécuté avec un message
//                $this->get('store.backend.notification')
//                    ->notify($id->getId(),
//                        "Attention, votre produit ".$id->getTitle()." est bientôt épuisée.",
//                        "product",
//                        "warning"
//                    );
//            }

            if($id->getQuantity() == 1 ){
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    'Votre bijoux '.$id->getTitle().' est un produit unique !'
                );
            }

            return $this->redirectToRoute('store_backend_product_list');

        }

        return $this->render('StoreBackendBundle:Product:edit.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Activate a product
     * @param Product $id
     * @param $action
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activateAction(Product $id, $action){
        // je récupère le manager de doctrine : Le conteneur d'objet de Doctrine
        $em = $this->getDoctrine()->getManager();

        $id->setActive($action);
        $em->persist($id);
        $em->flush();

        // je cré un message flash avec pour clef "success"
        // et un message de confirmation
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre produit a bien été activé'
        );
        return $this->redirectToRoute('store_backend_product_list'); //redirect
    }

    /**
     * Cover a product
     * @param Product $id
     * @param $action
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function coverAction(Product $id, $action){
        // je récupère le manager de doctrine : Le conteneur d'objet de Doctrine
        $em = $this->getDoctrine()->getManager();

        $id->setCover($action);
        $em->persist($id);
        $em->flush();

        // je cré un message flash avec pour clef "success"
        // et un message de confirmation
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre produit a bien été affiché en première page'
        );
        return $this->redirectToRoute('store_backend_product_list'); //redirect
    }


}

