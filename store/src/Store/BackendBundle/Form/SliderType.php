<?php
namespace Store\BackendBundle\Form;
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 14/04/15
 * Time: 15:59
 */

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Store\BackendBundle\Repository\CategoryRepository;
use Store\BackendBundle\Repository\CmsRepository;

/**
 * Le suffixe Type est obligatoire pour les classes formulaire
 * Class ProductType
 * Formulaire de création de produits
 * @package Store\BackendBundle\Form
 */
class SliderType extends AbstractType{

    /**
     * @var $user
     */
    protected $user;

    /**
     * User param
     * @param int $user
     */
    public function __construct($user = 1){
        $this->user = $user;
    }

    /**
     * Méthode qui va construire un formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', null, array(
            'label' => 'Légende de l\'image',
            'required' => true,
            'attr'  => array(
                'class'         => 'form-control',
                'placeholder'   => 'Ecrire une légende à l\'image',
                'pattern'       => '[a-zA-Z0-9- ]{5,}',
            )
        ));

        $builder->add('file','file',array(
            'label'     => 'Image de présentation',
            'required'  => false,
            'attr'      => array(
                'class' => 'form-control',
                'accept'=> 'image/*',
                'capture'=> 'capture'
            )

        ));

        // methode numéro 1
        $builder->add('product', null, array(
            'label' => 'Produit',
            'class' => 'StoreBackendBundle:Product',
            'property' => 'title',
            'query_builder' =>function(EntityRepository $er){
                    return $er->createQueryBuilder('p')
                        ->where('p.jeweler = :user')
                        ->orderBy('p.title', 'ASC')
                        ->setParameter('user', $this->user);
                },
        ));

        // methode numéro 2
//        $builder->add('category', 'entity', array(
//            'label' => 'Catégorie',
//            'class' => 'StoreBackendBundle:Category',
//            'property' => 'title',
//            'multiple' => true, // liste déroulante à choix multiple
//            'expanded' => true, // pour la mettre en checkBox
//            // si multiple est à false expended donnera des boutons radio
//            'query_builder' =>function(CategoryRepository $er){
//                    return $er->getCategoryByUserBuilder($this->user);
//                },
//        ));

        $builder->add('active', null, array(
            'label' => "Produit activé dans la boutique ?",
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
            'data_class' => 'Store\BackendBundle\Entity\Slider',
        ));
    }

    /**
     * Méthode dépréciée pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\BackendBundle\Entity\Slider',
        ));
    }
}