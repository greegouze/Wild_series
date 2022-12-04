<?php


namespace App\DataFixtures;


use App\Entity\Program;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface

{
    const PROGRAMES = [
        'Star warz' => 'La guerre des étoiles',
        'Breaking bad' => 'El parrain',
        'Le seigneur des anneaux' => 'Le Hobbit',
        'Games of thrônes' => 'les noces poupres',
        'Death Note' => 'Le dernier jour'
    ];

    public function load(ObjectManager $manager)

    {
        $i = 0;

        foreach (self::PROGRAMES as $key => $programName) { // boucle sur ma constante

            $program = new Program(); //instancie un objet program

            $program->setTitle($key); // j'ajoute le titre(star wars)

            $program->setSynopsis($programName); //j'ajoute le synopsis

            $program->setCategory($this->getReference('category_Action'));
            
            $this->addReference('program_' . $i, $program); //je l'ajoute à la catégorie action

            $manager->persist($program); //perist = sauvegarde la requête et ci il y a des requêtes supplémentaire et a la fin il envoie tout avec le flush(evite de faire une par une)

            $i++;
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
