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
 * Class OrdersRepository
 * @package store\backendBundle\Repository
 */
class OrdersRepository extends EntityRepository{


    /**
     * @param $user
     * @return mixed
     *
     * SELECT COUNT(o.id) AS nb
     * FROM orders AS o
     * WHERE o.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT COUNT(o) AS nb
                FROM StoreBackendBundle:Orders o
                WHERE o.jeweler = :user
                "
            )
            ->setParameter('user', $user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }

    /**
     * @param $user
     * @return mixed
     *
     * SELECT SUM(o.total) AS total
     * FROM orders AS o
     * WHERE o.jeweler_id = 1
     *
     */
    public function getTotalcdeByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT SUM(o.total) AS total
                FROM StoreBackendBundle:Orders o
                WHERE o.jeweler = :user
                "
            )
            ->setParameter('user',$user);

        // retourne 1 résultat ou null (correspond à row dans codeIgniter)
        return $query->getOneOrNullResult();
    }

    /**
     * @param $user
     * @return mixed
     *
     * SELECT SUM(o.total) AS total
     * FROM orders AS o
     * WHERE o.jeweler_id = 1
     *
     */
    public function getFiveLastCdeByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT o
                FROM StoreBackendBundle:Orders o
                WHERE o.jeweler = :user
                "
            )
            ->setParameter('user',$user);

        // retourne 1 tableau
        return $query->getResult();
    }

    /**
     * Requête pour obtenir les commandes des 6 derniers mois du jeweler en nombre par mois
     */
    public function getOrderGraphByUser($user, $dateBegin){

        // compter le nombre de commandes pour un jeweler précis
        // et pour une année et un mois précis
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT COUNT(o) AS nb, DATE_FORMAT(:dateBegin, '%Y-%m') AS d
                FROM StoreBackendBundle:Orders o
                WHERE o.jeweler = :user
                AND MONTH(o.dateCreated) = :month
                AND YEAR(o.dateCreated) = :year
                "
            )
            ->setParameters(array(
                'user' => $user,
                'dateBegin' => $dateBegin->format('Y-m-d'),
                'month' => $dateBegin->format('m'),
                'year' => $dateBegin->format('Y')
            ));
        // Retourne un seul résultat
        return $query->getSingleResult();

    }


} 