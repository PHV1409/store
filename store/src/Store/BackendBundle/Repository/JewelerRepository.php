<?php
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 21/04/15
 * Time: 11:25
 */

namespace Store\BackendBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsuportedUserException;
use Doctrine\ORM\NoResultException;


/**
 * Class JewelerRepository
 * @package Store\BackendBundle\Repository
 */
class JewelerRepository Extends EntityRepository implements UserProviderInterface{

    /**
     * Load Active User by Username or Email
     * Méthode de chargement de l'utilisateur : par son email ou username
     * @param string $username
     * @return UserInterface|void
     */
    public function loadUserByUsername($username){
        $q = $this
            ->createQueryBuilder('j')
            ->select('j, g')
            ->leftJoin('j.groups','g')
            ->where('j.username = :username OR j.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        /**
         *  Essayer de récupérer un utilisateur avec try{} catch{}
         */
        try {
            // La méthode Query::getSingleResult() lance une exception NoResult Exception
            // s'il n'y a pas d'entrée correspondante aux critères

            // Me retourne qu'un seul résultat avec la méthode getSingleResult()
            $user = $q->getSingleResult();
        } catch (NoResultException $e){

            // si il n'y a aucun résultat, alors on retourne aucun utilisateur
            return null;
        }
        return $user;
    }

    /**
     * Rafraichi l'utilisateur par son token
     * Appeler pour Rafraichis l'utilisateur en session par son token à chaque requête
     * A chaque requête, le rafraichissement de la session se fait par le token
     * @param UserInterface $user
     * @return null|object|UserInterface
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user){
        $class = get_class($user);

        if(!$this->supportsClass($class)){
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        // utilise la méthode find() pour retrouver l'utilisateur depuis son ID
        return $this->find($user->getId());
    }

    /**
     * Get User Class reconize Authentification Class
     * Methode qui permet de déclarer cette classe repository
     * comme un Provider au mécanisme de sécurité de faire reconnaitre cette classe
     * comme EntityProvider
     * @param string $class
     * @return bool
     */
    public function supportsClass($class){
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }



} 