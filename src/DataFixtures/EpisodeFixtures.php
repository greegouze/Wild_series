<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Episode;
use App\Entity\Program;
use App\DataFixtures\SeasonFixtures;
use App\DataFixtures\CategoryFixtures;
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
        $faker = Factory::create();

        for ($k = 0; $k < count(CategoryFixtures::CATEGORIES); $k++)
            for ($j = 0; $j < count(ProgramFixtures::PROGRAMES); $j++) {
                for ($i = 0; $i < SeasonFixtures::SEASON_NUMBER; $i++) {
                    foreach (self::EPISODES as $episodeName) {

                        $episode = new Episode();

                        $episode->setTitle($episodeName);

                        $episode->setSynopsis($faker->paragraphs(2, true));

                        $episode->setSeason($this->getReference('category_' . $k . '_program_' . $j . '_season_' . $i));

                        $manager->persist($episode);
                    }

                    $manager->flush();
                }
            }
    }
    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont EpisodeFixtures dépend

        return [

            SeasonFixtures::class,

        ];
    }
}
