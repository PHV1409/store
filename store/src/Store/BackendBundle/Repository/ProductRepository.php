<?php
namespace Store\BackendBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 10/04/15
 * Time: 16:27
 */

/**
 * Class ProductRepository
 * @package store\backendBundle\Repository
 */
class ProductRepository extends EntityRepository{

    /**
     * Get all product of an user
     * @param null $user
     * @return array
     */
    public function getProductByUser($user = null){
        /**
         * nom du bundle : nom de l'entité
         * alias.nom de l'attribut de l'entité du FROM = : d'une variable nomée
         *
         * valeur de la variable nomée : user , valeur du paramètre
         */
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT p
                FROM StoreBackendBundle:Product p
                WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);

        return $query->getResult();
    }

    /**
     * Count all product
     * @param null $user
     * @return mixed
     *
     * SELECT COUNT(id)
     * FROM `product`
     * WHERE jeweler_id = 1
     */
    public function getCountByUser($user = null){
        // compte le nbr de produits pour un bijoutiers
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(p) AS nb
                FROM StoreBackendBundle:Product p
                WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }

    public function getProductQuantityIsLower($user = null){
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT p
                FROM StoreBackendBundle:Product p
                WHERE p.jeweler = : jeweler
                AND p.quantity < 5"
            )
            ->setParameters('jeweler', $user);

        return $query->getResult();
    }


} 