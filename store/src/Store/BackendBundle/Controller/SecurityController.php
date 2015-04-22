<?php
namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Jeweler;
use Store\BackendBundle\Form\JewelerSubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 20/04/15
 * Time: 12:33
 */

/**
 * Class SecurityController
 * @package Store\BackendBundle\Controller
 */
class SecurityController extends Controller{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request){

        $session = $request->getSession();

        if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }else{
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        // je retourne la vue index de mon dossier Sécurity
        return $this->render('StoreBackendBundle:Security:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));

    }

    /**
     * Subscribe Page for Jeweler
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subscribeAction(Request $request){

        $jeweler = new Jeweler();

        // je crée mon formulaire d'inscription au Jeweler
        $form = $this->createForm(new JewelerSubscribeType(), $jeweler, array(
            'validation_groups' => 'subscribe',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_security_subscribe')
             )
        ));

        // je lie le formulaire à la requête
        $form->handleRequest($request);

        if($form->isValid()){
            //1. je récupère la valeur de mon champ password
            // impérativement après avoir été hydraté par la méthode handleRequest
            $password = $form['password']->getData();

            // je récupère le service d'encodage de la sécurité de symfony2
            $factory = $this->get('security.encoder_factory');

            //2. je récupère l'encoder de mon jeweler (sha512)
            $encoder = $factory->getEncoder($jeweler);

            //3. Avec l'encodeur de sécurité, j'encode mon mot de passe avec l'encodeur et j'ajoute le salt
            $password = $encoder->encodePassword($password, $jeweler->getSalt()); // récupère le mot de passe

            //4. je renseigne le mot de passe encodé de mon jeweler
            $jeweler->setPassword($password); // modifier le mot de passe encodé avec l'encodage

            $em = $this->getDoctrine()->getManager(); // je récupère le manager de Doctrine

            //5. je récupère le ROLE_JEWELER par les ROLES
            $group = $em->getRepository('StoreBackendBundle:Groups')->find(1);

            // j'associe mon jeweler au ROLE_JEWELER
            $jeweler->addGroup($group);

            $em->persist($jeweler); // enregistrement
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre compte a bien été créé'
            );
            $this->get('session')->getFlashBag()->add(
                'info',
                'Vous pouvez maintenant vous identifier'
            );

            return $this->redirectToRoute('store_backend_security_login'); // redirection selon la route
        }
        return $this->render('StoreBackendBundle:Security:subscribe.html.twig', array(
            'form' => $form->createView()
        ));
    }


}