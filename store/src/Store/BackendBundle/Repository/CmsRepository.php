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
class CmsRepository extends EntityRepository{

    /**
     * Get all product of an user
     * @param null $user
     * @return array
     */
    public function getCmsByUser($user = null){
        /**
         * Récupère les cms
         *
         */
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT cm
                FROM StoreBackendBundle:Cms cm
                JOIN cm.product p
                WHERE p.jeweler = :user
                GROUP BY p.jeweler"
            )
            ->setParameter('user', $user);

        return $query->getResult();

    }

    /**
     * @param $user
     * @return mixed
     *
     * SELECT COUNT(id)
     * FROM cms
     * WHERE jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT COUNT(cm) AS nb
                FROM StoreBackendBundle:Cms cm
                WHERE cm.jeweler = :user"
            )
            ->setParameter('user',$user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }

} 