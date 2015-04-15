<?php
namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 15/04/15
 * Time: 16:56
 */

class CategoryType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, array(
            'label' => 'Nom de la catégorie',
            'required' => true,
            'attr'  => array(
                'class'         => 'form-control',
                'placeholder'   => 'Mettre un titre soigné',
                'pattern'       => '[a-zA-Z0-9- ]{5,}',
            )
        ));

        $builder->add('description', null, array(
            'label' => 'description longue', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Description longue de la catégorie',
            )
        ));

        $builder->add('position', null, array(
            'label' => "Ordre d'affichage",
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => "Ordre d'affichage",
            )
        ));

        $builder->add('envoyer', 'submit', array(
            'attr'  => array(
                'class' => 'btn btn-primary btn-sm',
            )
        ));



    }


    /**
     * nom du formulaire
     * @return string
     */
    public function getName()
    {
        return "store_backend_category";
    }

    /**
     * Cette méthode me permet de lier mon formulaire à mon entité product
     * car mon formulaire enregistre un produit dans la table product
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // Je lie le formulaire à l'entité Product
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Category',
        ));
    }

    /**
     * Méthode dépréciée pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Category',
        ));
    }

}