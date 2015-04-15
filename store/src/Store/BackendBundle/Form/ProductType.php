<?php
namespace Store\BackendBundle\Form;
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 14/04/15
 * Time: 15:59
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Le suffixe Type est obligatoire pour les classes formulaire
 * Class ProductType
 * Formulaire de création de produits
 * @package Store\BackendBundle\Form
 */
class ProductType extends AbstractType{

    /**
     * Méthode qui va construire un formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // ajoute un champs dans mon formulaire
        // le nom de mes champs sont les attributs de l'entité Product
        // Le deuxième argument de ma fonction add est le type d'argument
        // le troisième argument de ma fonction add() est l'option du champ
        $builder->add('title', null, array(
            'label' => 'Nom de mon bijoux',
            'required' => true,
            'attr'  => array(
                'class'         => 'form-control',
                'placeholder'   => 'Mettre un titre soigné',
                'pattern'       => '[a-zA-Z0-9- ]{5,}',
            )
        ));

        $builder->add('ref', null, array(
            'label' => 'Référence du produit', // label de mon champ
            'required' => true,
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'AAXX',
                'pattern'       => '[A-Z]{2}[0-9]{2,}',
            )
        ));

        $builder->add('category', null, array(
            'label' => 'Catégorie(s) associée(s)', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('summary', null, array(
            'label' => 'Petit résumé', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Petit résumé du bijoux',
                'pattern'       => '.{10,}',
            )
        ));

        $builder->add('description', null, array(
            'label' => 'description longue', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Description longue du bijoux',
            )
        ));

        $builder->add('composition', null, array(
            'label' => 'description de la composition', // label de mon champ
            'required' => true,
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Description de la composition du bijoux',
            )
        ));

        $builder->add('price', 'money', array(
            'label' => 'Prix HT en € du bijou', // label de mon champ
            'required' => true,
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Prix HT en € du bijou',
                'pattern'       => '',
            )
        ));

        $builder->add('taxe', 'choice', array(
            'choices' => array('5'=>'5', '19.6' => '19.6', '20' => '20'),
            'required'  => true, // liste déroulante obligatoire
            'preferred_choices' => array('20'), // champs choisi par défaut
            'label' => 'Taxe appliquée', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('quantity', 'number', array(
            'required' => true,
            'label'    => 'Quantité du produit',
            'attr'     => array(
                'class'   => 'form-control',
                'pattern' => '[0-9]{1,4}',
            )
        ));

        $builder->add('active', null, array(
            'label' => "Produit activé dans la boutique ?",
        ));

        $builder->add('cover', null, array(
            'label' => "Produit mis en page d'accueil dans la boutique ?",
        ));

        $builder->add('cms', null, array(
            'label' => 'Page(s) associée(s) au produit',
            'attr'  => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('supplier', null, array(
            'label' => 'Fournisseur(s) associé(s) au produit',
            'attr'  => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('tag', null, array(
            'label' => 'Tag(s) associé(s) au produit',
            'attr'  => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('slug', null, array(
            'label' => 'url explicite ( sans espace ni caractères spéciaux)',
            'attr'     => array(
                'class'   => 'form-control',
                'pattern' => '[a-z-]{1,}',
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
        return "store_backend_product";
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
            'data_class' => 'Store\BackendBundle\Entity\Product',
        ));
    }

    /**
     * Méthode dépréciée pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Product',
        ));
    }
}