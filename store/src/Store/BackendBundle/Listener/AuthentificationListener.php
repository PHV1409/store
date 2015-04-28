<?php
namespace Store\BackendBundle\Listener;

use Doctrine\ORM\EntityManager;
use Store\BackendBundle\Notification\Notification;
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
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var Notification
     */
    protected $notification;

    /**
     *
     * Le constructeur de ma class
     * avec 2 arguments: l'Entité Manager et le Contexte de sécurité
     *
     * @param EntityManager $em
     * @param SecurityContextInterface $securityContext
     * @param Notification $notification
     */
    public function __construct(EntityManager $em, SecurityContextInterface $securityContext, Notification $notification){

        // je stocke dans 2 attributs les services récupérés
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->notification = $notification;
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

        // récupère tous les produits  de l'utilisateur via le repository ProductRepository et
        // qui va récupéré les produits de l'utilisateur dont la quantité < 5
        $products = $this->em->getRepository('StoreBackendBundle:Product')->getProductQuantityIsLower($user);

        // je déclare une notification dans mes produits
        // pour chaque produit
        foreach($products as $product){
            // si la quantité du produit est égale à 1
            if($product->getQuantity() == 1){
                $this->notification->notify($product->getId(),
                    'Il ne vous reste plus qu\'un seul exemplaire de votre produit' .$product->getTitle().'.',
                    'product',
                    'danger'
                );
            }else{
                $this->notification->notify($product->getId(),
                    'Attention, votre produit ' .$product->getTitle().' est bientôt épuisé.',
                    'product',
                    'warning'
                );
            }
        }

        // Met à jour la date de connexion de l'utilisateur
        $user->setDateAuth($now);

        // enregistre mon utilisateur avec sa date modifié
        $this->em->persist($user);
        $this->em->flush();
    }


}