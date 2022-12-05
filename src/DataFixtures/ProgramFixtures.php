<?php


namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Program;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface

{
    const PROGRAMES = [
        'Star warz',
        'Breaking bad',
        'Le seigneur des anneaux',
        'Games of thrônes',
        'Death Note'
    ];

    public function load(ObjectManager $manager)

    {
        $faker = Factory::create();
        
        foreach (CategoryFixtures::CATEGORIES as $key => $categorymName) { // boucle sur ma constante
            foreach (self::PROGRAMES as $programKey => $programName) {
                $program = new Program(); //instancie un objet program
                $program->setTitle($programName); // j'ajoute le titre(star wars)
                $program->setSynopsis($faker->paragraph(2,true)); //j'ajoute le synopsis
                $category = $this->getReference('category_' . $key);
                $program->setCategory($category);
                $this->addReference('category_' . $key . '_program_' . $programKey, $program); //je l'ajoute à la catégorie action
                $manager->persist($program); //perist = sauvegarde la requête et ci il y a des requêtes supplémentaire et a la fin il envoie tout avec le flush(evite de faire une par une)

            }
        }


        $manager->flush();
    }


    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend

        return [

            CategoryFixtures::class,

        ];
    }
}
