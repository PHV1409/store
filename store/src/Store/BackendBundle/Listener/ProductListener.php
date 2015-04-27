<?php
namespace Store\BackendBundle\Listener;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Notification\Notification;

/**
 * Class ProductListener
 * @package Store\BackendBundle\Listener
 */
class ProductListener {

    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @var Notification
     */
    protected $em;

    /**
     * Constructeur qui reçoit en argument le service notification
     * @param Notification $notification
     */
    public function __construct(Notification $notification){
        $this->notification = $notification;
    }

    /**
     * Méthode qui sera appelé depuis mon service yml
     * et reçoit en argument mon évènement Doctrine
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args){

       // je récupère mon objet après modification (update)
        $entity = $args->getEntity();
        $em = $args->getEntityManager(); // récupère l'entité manager

        // si mon objet est un objet de mon entité product
        if($entity instanceof Product){
            // exit(var_dump($entity));

            // je récupère le titre de mon produit
            $title = $entity->getTitle();

            # 2 tableaux avec accents
            $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
            $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
            // slugifier mon titre stocké dans une variable $slug
            $slug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$title)));

            // modifie le titre en slug
            $entity->setSlug($slug);

            $em->persist($entity); // j'enregistre en base de données
            $em->flush();

            // Si la quantité de mon produit est égale à 1
            if($entity->getQuantity() == 1){
                // Je notifie la quantité de ce produit
                // avec la méthode notify()
                $this->notification->notify($entity->getId(),
                    'Attention, iml ne reste qu\'un exemplaire de votre produit '.$entity->getTitle().'.',
                    'product',
                    'danger'
                );
            }

            // Si la quantité de mon produit est inférieur à 5
            elseif($entity->getQuantity() < 5){
                // Je notifie la quantité de ce produit
                // avec la méthode notify()
                $this->notification->notify($entity->getId(),
                    'Attention, votre produit '.$entity->getTitle().' est bientôt épuisé.',
                    'product',
                    'warning'
                );
            }
        }
    }

    /**
     * Méthode appelé avant la modification de mon objet
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args){

        // Je récupère mon objet avant sa persistance
        $entity = $args->getEntity();

        // si mon objet est un objet de mon entité product
        if($entity instanceof Product){
            $now = new \DateTime('now'); // objet DateTime à aujourd'hui pour récupéré la date
            $entity->setDateUpdated($now); // modification de la dateUpdated
        }
    }

    /**
     * Méthode qui sera appelé depuis mon service yml
     * et reçoit en argument mon évènement Doctrine2
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args){

        /**
         * appel d'une méthode dans une autre: appel de la méthode postUpdate
         */
        $this->postUpdate($args);

    }
} 