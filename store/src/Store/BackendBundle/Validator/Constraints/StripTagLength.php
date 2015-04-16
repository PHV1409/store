<?php
namespace Store\BackendBundle\Validator\Constraints;
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 16/04/15
 * Time: 15:55
 */
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StripTagLength extends Constraint{
    // message qui apparait dans ma contrainte de validation
    public $message = "Le texte est trop long";
}