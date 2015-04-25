<?php
namespace Store\BackendBundle\Twig\Extensions;




class StoreBackendExtension extends \Twig_Extension{

    /**
     * Fonction qui me retourne tous mes filtres créés
     * @return array
     */
    public function getFilters(){

        // Retourne un tableau de filtres créés
        return array(
            // Twig_SimpleFilter :
            // - 1er argument est le nom du filtre en TWIG
            // - 2eme argument est le nom de la fonction que je vais créer
            new \Twig_SimpleFilter('state', array($this, 'state')),
        );
    }

    public function state($state){
        if($state == 2 ){
            $badge = "<span class='label label-success'> Actif </span>";
        }
        elseif($state == 1 ){
            $badge = "<span class='label label-info'> En cours </span>";
        }
        else{
            $badge = "<span class='label label-warning'> Annulé </span>";
        }

        return $badge;
    }

    public function getName(){
        return 'store_backend_extension';
    }

} 