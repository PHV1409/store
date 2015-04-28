<?php
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 28/04/15
 * Time: 11:13
 */

namespace Store\BackendBundle\Repository;


use Doctrine\ORM\EntityRepository;

/**
 *
 * Class MessageRepository
 * @package Store\BackendBundle\Repository
 */
class MessageRepository extends EntityRepository{

    /**
     * récupère les messages de l'utilisateur
     * @param $user
     * @param int $limit
     * @return mixed
     */
    public function getLastMessagesByUser($user, $limit = 5){
        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT m
                FROM StoreBackendBundle:Message m
                WHERE m.jeweler = :user
                ORDER BY m.id DESC
                "
            )
            ->setParameter('user', $user)
            ->setMaxResults($limit);
        return $query->getResult();
    }

} 