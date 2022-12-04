<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Program;
use App\DataFixtures\SeasonFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        'Episode 1',
        'Episode 2',
        'Episode 3',
        'Episode 4',
        'Episode 5',
    ];
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(ProgramFixtures::PROGRAMES); $i++) {
            for ($j = 0; $j < SeasonFixtures::SEASON_NUMBER; $j++) {
                foreach (self::EPISODES as $episodeName) {

                    $episode = new Episode();

                    $episode->setTitle($episodeName);



                    $episode->setSeason($this->getReference('program_' . $i . '_season_' . $j));

                    $manager->persist($episode);
                }

                $manager->flush();
            }
        }
    }
    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend

        return [

            SeasonFixtures::class,

        ];
    }
}
