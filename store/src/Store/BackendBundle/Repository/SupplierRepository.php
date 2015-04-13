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
 * Class SupplierRepository
 * @package store\backendBundle\Repository
 */
class SupplierRepository extends EntityRepository{

    /**
     * Get all Supplier of an user
     * @param null $user
     * @return array
     */
    public function getSupplierByUser($user = null){
        /**
         * Récupère les Supplier
         */
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT s
                FROM StoreBackendBundle:Supplier s
                JOIN s.product p
                WHERE p.jeweler = :user
                GROUP BY p.jeweler"
            )
            ->setParameter('user', $user);

        return $query->getResult();
    }


    /**
     * Get all product of an user
     * @param null $user
     * @return array
     */
    public function getCountByUser($user = null){
        /**
         * Récupère les fournisseurs des produits
         * où la boutique des produits est égal à mon paramètre
         *
         * SELECT COUNT(DISTINCT(s.id))
         * FROM supplier AS s
         * INNER JOIN product_supplier AS ps ON s.id = ps.supplier_id
         * INNER JOIN product AS p ON ps.product_id = p.id
         * WHERE p.jeweler_id = 1
         */
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(DISTINCT s) AS nb
                FROM StoreBackendBundle:Supplier s
                JOIN s.product AS p
                WHERE p.jeweler = :user
                "
            )
            ->setParameter('user', $user);

        return $query->getOneOrNullResult();

    }


} 