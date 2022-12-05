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

        foreach (self::CATEGORIES as $categoryKey => $categoryName) {

            $category = new Category();

            $category->setName($categoryName);

            $manager->persist($category);

            $this->addReference('category_' . $categoryKey, $category);
        }

        $manager->flush();
    }
}
