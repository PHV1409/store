<?php
namespace Store\BackendBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 16/04/15
 * Time: 16:07
 */

class StripTagLengthValidator extends ConstraintValidator{

    public function validate($value, Constraint $constraint){
        // si la longueur de ma chaine avec suppression des tag HTML
        // est > à 500 caractères
        if(900 < strlen(strip_tags($value))){
            $this->context->addViolation(
                $constraint->message, array('%string%' => $value));
        }
    }

}