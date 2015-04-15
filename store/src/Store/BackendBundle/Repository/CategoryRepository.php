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
class CategoryRepository extends EntityRepository{

    /**
     * Get all product of an user
     * @param null $user
     * @return array
     */
    public function getCategoryByUser($user = null){
        /**
         * Récupère les catégories des produits
         */
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT c
                FROM StoreBackendBundle:Category c
                WHERE c.jeweler = :user
                "
            )
            ->setParameter('user', $user);

        return $query->getResult();
    }

    /**
     * @param $user
     * @return mixed
     *
     * SELECT COUNT(id)
     * FROM category
     * WHERE jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT COUNT(c) AS nb
                FROM StoreBackendBundle:Category c
                WHERE c.jeweler = :user"
            )
            ->setParameter('user',$user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }
    /**
     * @param $user
     * @return mixed
     *
     * SELECT c.title, COUNT(p.id)
     * FROM `category` AS c
     * INNER JOIN product_category AS pc ON c.id= pc.category_id
     * INNER JOIN product AS p ON pc.product_id = p.id
     * WHERE p.jeweler_id = 1
     * GROUP BY c.id
     */
    public function getCatPopulaireByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT c
                FROM StoreBackendBundle:Category c
                INNER JOIN c.product p
                WHERE p.jeweler = :user
                GROUP BY c.id
                "
            )
            ->setParameter('user',$user);
        //exit(print_r($query->getSQL()));

        // retourne 1 résultat ou null
        return $query->getResult();
    }


} 