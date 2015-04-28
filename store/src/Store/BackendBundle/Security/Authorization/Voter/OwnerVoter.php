<?php
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 28/04/15
 * Time: 14:39
 */

namespace Store\BackendBundle\Security\Authorization\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OwnerVoter: qui va voter si l'utilisateur est permis de faire une action
 * @package Store\BackendBundle\Security\Authorization\Voter
 */
class OwnerVoter implements VoterInterface{

    /**
     * Cet attribut of User
     * Cette méthode me permet de récupérer le ou les attribut(s) envoyé(s) depuis mon controller
     * @param string $attribute
     * @return bool|string
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * Cette méthode me permet de faire des restrictions sur l'utilisation de ce voter
     * @param string $class
     * @return bool|void
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * LE PLUS IMPORTANT
     * Cette méthode me permet de voter
     * Mécanisme que l'on implémente pour voter les droits et permissions de l'utilisateur
     * @param TokenInterface $token
     * @param null|object $object
     * @param array $attributes
     * @return int|void
     *
     * le token permet de récupérer l'utilisateur
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        /**
         * VoterInterface::ACCESS_DENIED: Accès non permis (erreur 403)
         * VoterInterface::ACCESS_GRANTED: Accès authorisé
         * VoterInterface::ACCESS_ABSTAIN: S'abstenir de voter sur le mécanisme d'authorisation
         */

        // get current logged in user
        $user = $token->getUser();

        // si l'utilisateur n'est pas connecté
        if(!$user instanceof UserInterface){
            return VoterInterface::ACCESS_DENIED;
        }

        // si le jeweler id est égale à l'id de l'utilisateur
        if(method_exists($object, 'getJeweler')){
            if($object->getJeweler()->getId() == $user->getId()){
                return VoterInterface::ACCESS_GRANTED; // accès permis
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }


} 