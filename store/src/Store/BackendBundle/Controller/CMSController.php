<?php

// l'endroit ou je déclare ma classe StaticsController
namespace Store\BackendBundle\Controller;

// j'inclue la classe controller de symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Cms;
use Store\BackendBundle\Form\CmsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CMSController
 * @package Store\BackendBundle\Controller
 */
class CMSController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){

        // recupère le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère tous les catégories de ma base de données
        $pages = $em->getRepository('StoreBackendBundle:Cms')->findAll(); // Nom du Bundle: Nom de l'entité

        // Requête: SELECT * FROM product
        // Je retourne la vue List contenue dans le dossier Category de mon Bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:CMS:list.html.twig',array(
            'pages' => $pages
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

        // Je récupère tous les cms de ma base de données
        $cms = $em->getRepository('StoreBackendBundle:Cms')->find($id); // Nom du Bundle: Nom de l'entité

        // je retourne ma vue view de Catégorie où je transmet l'id en vue et le name
        return $this->render('StoreBackendBundle:CMS:view.html.twig',
            array(
                'cms' => $cms // le nom de ma clé sera le nom de ma variable en vue
            )
        );
    }


    public function removeAction($id){

        // recupere le manager de doctrine : le conteneur d'objet
        $em = $this->getDoctrine()->getManager();

        // Je récupère le cms de ma base de données
        $cms = $em->getRepository('StoreBackendBundle:Cms')->find($id); // Nom du Bundle: Nom de l'entité

        $em->remove($cms);
        $em->flush();

        return $this->redirectToRoute('store_backend_cms_list');
    }


    public function newAction(Request $request){
        $cms = new Cms();

        $em = $this->getDoctrine()->getManager();
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1); // je récupère le jeweler num 1
        $cms->setJeweler($jeweler); // J'associe mon jeweler à ma catégorie
        $form = $this->createForm(new CmsType(), $cms, array(
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate', // pour virer la validation html5
                'action' => $this->generateUrl('store_backend_cms_new')
            )
        ));
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cms);
            $em->flush();

            return $this->redirectToRoute('store_backend_cms_list');
        }

        return $this->render('StoreBackendBundle:CMS:new.html.twig',
            array('form' => $form->createView())
        );

    }


}

