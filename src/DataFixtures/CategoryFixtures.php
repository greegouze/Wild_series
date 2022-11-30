<?php


namespace App\DataFixtures;


use App\Entity\Category;

use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends Fixture

{
    //je creer mes constantes
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
        'Horreur',
    ];

    public function load(ObjectManager $manager)

    {
        //je boucle ainsi sur mon tableau 
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName); //setname me permet de changer de nom au fur est à mesure de ma boucle

            $manager->persist($category); //persist-> transforme en objet
        }
        $manager->flush(); //flush() envoie en base donnée
    }
}
