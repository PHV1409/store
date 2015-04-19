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

class CmsType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, array(
            'label' => 'Nom de la page CMS',
            'required' => true,
            'attr'  => array(
                'class'         => 'form-control',
                'placeholder'   => 'Mettre un titre soigné',
                'pattern'       => '[a-zA-Z0-9- ]{5,}',
            )
        ));

        $builder->add('summary', null, array(
            'label' => 'descriptif résumé', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Description résumée de la page CMS',
            )
        ));

        $builder->add('description', null, array(
            'label' => 'description longue', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Description longue de la catégorie',
            )
        ));


        $builder->add('image', 'text', array(
            'label' => 'image', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'http://',
            )
        ));
        $builder->add('dateActive', 'date', array(
//            'widget' => 'text',
//            'pattern'  => '{{ day }}--{{ month }}--{{ year }}',
            'widget' => 'single_text',
            'format' => 'dd-MM-yy',
            'attr' => array('class' => 'date'),
        ));

        $builder->add('video', null, array(
            'label' => 'video', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
                'placeholder'   => 'Placez votre iframe ici',
            )
        ));



        $builder->add('state', 'choice', array(
            'choices' => array('0'=>'Inactif', '1' => 'En cours de relecture', '2' => 'En ligne'),
            'required'  => false,
            'label' => 'Etat', // label de mon champ
            'attr'  => array(
                'class' => 'form-control',
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
        return "store_backend_cms";
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
            'data_class' => 'Store\BackendBundle\Entity\Cms',
        ));
    }

    /**
     * Méthode dépréciée pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Cms',
        ));
    }

}