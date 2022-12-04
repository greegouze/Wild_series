<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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


    #[Route('/show/{id}', name: 'show')]

    public function show(int $id, ProgramRepository $programRepository): Response

    {

        $program = $programRepository->findOneBy(['id' => $id]);


        // same as $program = $programRepository->find($id);


        if (!$program) {

            throw $this->createNotFoundException(

                'No program with id : ' . $id . ' found in program\'s table.'

            );
        }

        return $this->render('program/show.html.twig', [

            'program' => $program,

        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', name: 'season_show')]

    public function showSeason(SeasonRepository $seasonRepository, ProgramRepository $programRepository, int $programId, int $seasonId): Response

    {

        $program = $programRepository->findOneBy(['id' => $programId]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $programId . ' found in program\'s table.'
            );
        }
        $season = $seasonRepository->findOneBy(['id' => $seasonId]);
       //dd($season);
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }
}
