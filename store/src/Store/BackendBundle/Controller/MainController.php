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

        // $this->get() => accède au conteneur de service
        // et récupère le service store.backend.email
//        $mail = $this->get('store.backend.email');
//        $mail->send(); // appel de ma méthode pour envoyer un email

        // $this->get() => accède au conteneur du service
        // la methode notify sera exécuté avec un message de bienvenue
        //$this->get('store.backend.notification')->notify('Bienvenue sur la plateforme');

        // Récupère Doctrine Manager
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        // Je récupère le nombre de produits de mon bijoutier numéro 1
        // Je fais appel à mon Repository ProductRepository
        // et à la fonction getCountByUser(1);
        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($user);
        $nbcat = $em->getRepository('StoreBackendBundle:Category')->getCountByUser($user);
        $nbcms = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser($user);
        $nbcom = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($user);
        $nbsup = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($user);
        $nbcde = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser($user);
        $totalcde = $em->getRepository('StoreBackendBundle:Orders')->getTotalcdeByUser($user);
        $commentsactifs = $em->getRepository('StoreBackendBundle:Comment')->getCommentsActifsByUser($user);
        $commentsinactifs = $em->getRepository('StoreBackendBundle:Comment')->getCommentsInactifsByUser($user);
        $fivelastcde = $em->getRepository('StoreBackendBundle:Orders')->getFiveLastCdeByUser($user);
        $catpopulaire = $em->getRepository('StoreBackendBundle:Category')->getCatPopulaireByUser($user);

        // chart in last 6 months
        $statorder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('now'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-1 MONTH'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-2 MONTH'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-3 MONTH'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-4 MONTH'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Orders')->getOrderGraphByUser($user, new \DateTime('-5 MONTH'));




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
                'commentsactifs' => $commentsactifs,
                'commentsinactifs' => $commentsinactifs,
                'fivelastcde' => $fivelastcde,
                'catpopulaire' => $catpopulaire,
                'statorder' => $statorder
            )
        );
    }

}