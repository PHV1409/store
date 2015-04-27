<?php
namespace Store\BackendBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthentificationListener
 * @package Store\BackendBundle\Listener
 */
class AuthentificationListener {

    /**
     * @var null|SecurityContextInterface
     */
    protected $em;

    /**
     *
     * Le constructeur de ma class
     * avec 2 arguments: l'Entité Manager et le Contexte de sécurité
     *
     * @param EntityManager $em
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(EntityManager $em, SecurityContextInterface $securityContext){

        // je stocke dans 2 attributs les services récupérés
        $this->em = $em;
        $this->securityContext = $securityContext;

    }

    /**
     * C'est la méthode qui est déclenché après l'évènement InteractiveLogin
     * qui est l'action de login dans la sécurité
     * @param InteractiveLoginEvent $event
     */
    public function onAuthentificationSuccess(InteractiveLoginEvent $event){
        $now = new \DateTime('now');

        // récupère l'utilisateur courant connecté
        $user = $this->securityContext->getToken()->getUser();

        // Met à jour la date de connexion de l'utilisateur
        $user->setDateAuth($now);

        // enregistre mon utilisateur avec sa date modifié
        $this->em->persist($user);
        $this->em->flush();
    }


}