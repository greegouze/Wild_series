<?php

namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASON_NUMBER = 5; // creer  une constante saison comportznt 5aisons

    public function load(ObjectManager $manager)
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker

        $faker = Factory::create();
        /**

         * L'objet $faker que tu récupère est l'outil qui va te permettre 

         * de te générer toutes les données que tu souhaites

         */

        for ($j = 0; $j < count(ProgramFixtures::PROGRAMES); $j++) { // je boucle sur mon tableau de programme auquel je lui ajoute a chaque tour de boucle une saison allan max 5saison(constante)
            for ($i = 0; $i < self::SEASON_NUMBER; $i++) {
                $season = new Season();
                $season->setNumber($i);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($this->getReference('program_' . $i)); // je lui donne un programme et lui affiche une référence(saion)
                $this->addReference('program_' . $j . '_season_' . $i, $season); // en gros, program_star wars_season_1. ($season est l'objet a qui je lui donne la réf)
                $manager->persist($season); // je sauvegarde 
            }

            $manager->flush(); // et ensuite je l'envoie en basse de donnée
        }
    }


    public function getDependencies(): array

    {

        // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend

        return [

            ProgramFixtures::class,

        ];
    }
}
