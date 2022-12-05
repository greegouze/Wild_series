<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Program;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [

            'programs' => $programs,

        ]);
    }


    #[Route('/show/{id}', requirements: ['id' => '\d+'], name: 'show')]

    public function show(Program $program): Response

    {
        // same as $program = $programRepository->find($id)

        return $this->render('program/show.html.twig', [

            'program' => $program,

        ]);
    }

    #[Route('/{program}/seasons/{season}', requirements: ['id' => '\d+'], name: 'season_show')] // le paramtre de ma route doit être identique à ma variable 
    #[Entity('program', options: ['mapping' => ['program' => 'id']])]//{program} donc ['program' => 'id' ] pareil pour la vue twig {program: program.id}
    #[Entity('season', options: ['mapping' => ['season' => 'id']])]
    public function showSeason(Season $season, Program $program): Response
    {

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }
    #[Route('/program/{program}/season/{season}/episode/{episode}', requirements: ['id' => '\d+'], name: 'episode_show')]//{program} donc ['program' => 'id' ] pareil pour la vue twig {program: program.id}
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }
}
