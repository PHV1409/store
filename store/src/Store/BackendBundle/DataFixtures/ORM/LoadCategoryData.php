<?php
namespace Store\BackendBundle\DataFixures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Entity\Product;

/**
 * Cette classe me permettra de charger des catégories en base de données
 * Class LoadCategoryData
 * @package Store\BackendBundle\DataFixures\ORM
 */
class LoadCategoryData implements FixtureInterface{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){

        // ma 1ere catégorie
        $categorie = new Category();
        $categorie->setTitle('Colliers magnifiques');
        $categorie->setDescription('Jolie description de vos magnifiques colliers');

        // ma 2eme catégorie
        $categorie2 = new Category();
        $categorie2->setTitle('Colliers magnifiques');
        $categorie2->setDescription('Jolie description complète de vos bracelets glamours');

        // mon 1ere produit
        $product = new Product();

        $jeweler = $manager->getRepository('StoreBackendBundle:Jeweler')
            ->find(1);
        $product->addCategory($categorie);
        $product->setTitle('Colliers Azur été');
        $product->setDescription('Colliers Russe d\'été');
        $product->setComposition('Perles nacrées');
        $product->setActive(true);
        $product->setCover(true);
        $product->setJeweler($jeweler);

        $manager->persist($categorie);
        $manager->persist($categorie2);
        $manager->persist($product);

        $manager->flush();

    }
}