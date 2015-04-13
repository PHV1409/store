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
 * Class CommentRepository
 * @package store\backendBundle\Repository
 */
class CommentRepository extends EntityRepository{


    /**
     * @param $user
     * @return mixed
     *
     * SELECT COUNT(c.id)
     * FROM comment AS c
     * INNER JOIN product AS p ON c.product_id = p.id
     * WHERE p.jeweler_id = 1
     */
    public function getCountByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT COUNT(c) AS nb
                FROM StoreBackendBundle:Comment c
                JOIN c.product AS p
                WHERE p.jeweler = :user"
            )
            ->setParameter('user',$user);

        // retourne 1 résultat ou null
        return $query->getOneOrNullResult();
    }
    /**
     * @param $user
     * @return mixed
     *
     * SELECT COUNT(c.id)
     * FROM comment AS c
     * INNER JOIN product AS p ON c.product_id = p.id
     * WHERE p.jeweler_id = 1
     */
    public function getCommentsActifsByUser($user){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT c
                FROM StoreBackendBundle:Comment c
                JOIN c.product AS p
                WHERE p.jeweler = :user
                AND c.state = 1"
            )
            ->setParameter('user',$user);

        // retourne 1 résultat ou null
        return $query->getResult();
    }




} 