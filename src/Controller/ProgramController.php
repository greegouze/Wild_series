<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\ProgramType;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        $requestStack->getSession();
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [

            'programs' => $programs,

        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        $requestStack->getSession();
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);
            $this->addFlash('success', 'The new program has been created');
            return $this->redirectToRoute('program_index');
        }
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
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
    #[Entity('program', options: ['mapping' => ['program' => 'id']])] //{program} donc ['program' => 'id' ] pareil pour la vue twig {program: program.id}
    #[Entity('season', options: ['mapping' => ['season' => 'id']])]
    public function showSeason(Season $season, Program $program): Response
    {

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }
    #[Route('/program/{program}/season/{season}/episode/{episode}', requirements: ['id' => '\d+'], name: 'episode_show')] //{program} donc ['program' => 'id' ] pareil pour la vue twig {program: program.id}
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $programRepository->save($program, true);
                $this->addFlash(
                    'success',
                    'the load has been successfully set'
                );
                return $this->redirectToRoute('program_index');
            }
        } else {
            $this->addFlash(
                'danger',
                'the load hasnot been successfully set'
            );
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
            $this->addFlash(
                'danger',
                'Well deleted'
            );
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }
}
