<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASON_NUMBER = 5;

    public function load(ObjectManager $manager)
    {
        for($j = 0; $j < count(ProgramFixtures::PROGRAMES); $j++){
            for ($i = 0; $i < self::SEASON_NUMBER; $i++) {
                $season = new Season();
                $season->setNumber($i);
                $season->setYear(2002);
                $season->setDescription('Synopsis text ' . $i);
                $season->setProgram($this->getReference('program_' . $i));
                $this->addReference('program_' . $j . '_season_' . $i, $season);
                $manager->persist($season);
            }

            $manager->flush();
        }
    }
    

    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend

        return [

            ProgramFixtures::class,

        ];
    }
}
