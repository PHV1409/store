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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(){
         // Récupère Doctrine Manager
        $em = $this->getDoctrine()->getManager();

        // Je récupère le nombre de produits de mon bijoutier numéro 1
        // Je fais appel à mon Repository ProductRepository
        // et à la fonction getCountByUser(1);
        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser(1);
        $nbcat = $em->getRepository('StoreBackendBundle:Category')->getCountByUser(1);
        $nbcms = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser(1);
        $nbcom = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser(1);
        $nbsup = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser(1);
        $nbcde = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser(1);
        $totalcde = $em->getRepository('StoreBackendBundle:Orders')->getTotalcdeByUser(1);
        $commentsactifs = $em->getRepository('StoreBackendBundle:Comment')->getCommentsActifsByUser(1);

        // je retourne la vue index de mon dossier Main
        return $this->render('StoreBackendBundle:Main:index.html.twig',
            array(
                'nbprod' => $nbprod,
                'nbcat' => $nbcat,
                'nbcms' => $nbcms,
                'nbcom' => $nbcom,
                'nbsup' => $nbsup,
                'nbcde' => $nbcde,
                'totalcde' => $totalcde,
                'commentsactifs' => $commentsactifs
            )
        );
    }

}