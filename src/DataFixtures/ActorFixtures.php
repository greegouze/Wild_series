<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Actor;
use App\DataFixtures\ProgramFixtures;
use App\DataFixtures\CategoryFixtures;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

                for ($i = 0; $i < self::ACTORS; $i++) {
                    $actor = new Actor();
                    $actor->setName($faker->lastName);
                    $manager->persist($actor);
                    $this->addReference('actor_' . $i, $actor);
                    for($j = 0; $j < 3; $j++){
                    $program = $this->getReference('category_' . $faker->numberBetween(0,4) . '_program_' . $faker->numberBetween(0,2));
                    $actor->addProgram($program);
                }
                $manager->flush();
            }
    }
    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont EpisodeFixtures dépend

        return [


            ProgramFixtures::class,

        ];
    }
}
