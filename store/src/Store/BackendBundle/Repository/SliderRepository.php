<?php
namespace Store\BackendBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class SliderRepository
 * @package Store\BackendBundle\Repository
 */
class SliderRepository extends EntityRepository{

    public function getSliderByUser($user = null){

        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT s
                FROM StoreBackendBundle:Slider s
                JOIN s.product AS p
                WHERE p.jeweler = :user"
            )
            ->setParameter('user', $user);

        return $query->getResult();

    }



}