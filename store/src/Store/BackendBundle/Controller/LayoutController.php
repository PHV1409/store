<?php
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 28/04/15
 * Time: 10:57
 */

namespace Store\BackendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class LayoutController
 * Ce controller spécial contiendra mon action rendus par Twig
 * @package Store\BackendBundle\Controller
 */
class LayoutController extends Controller{

    /**
     *
     */
    public function mymessagesAction(){


        // je récupère l'entity manager
        $em = $this->getDoctrine()->getManager();

        // récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        // récupérer mes messages depuis ma requête
        $messages = $em->getRepository('StoreBackendBundle:Message')
            ->getLastMessagesByUser($user, 7);

        return $this->render('StoreBackendBundle:Partial:mymessages.html.twig',
            array(
                'messages' => $messages
            )
        );
    }

    /**
     *
     */
    public function myordersAction(){

        // je récupère l'entity manager
        $em = $this->getDoctrine()->getManager();

        // récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        // récupérer mes messages depuis ma requête
        $orders = $em->getRepository('StoreBackendBundle:Orders')
            ->getLastOrdersByUser($user, 15);

        return $this->render('StoreBackendBundle:Partial:myorders.html.twig',
            array(
                'orders' => $orders
            )
        );
    }

} 