<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{ 

    #[Route('/', name: 'program_index')]
    public function index(): Response
    {

        return $this->render('program/index.html.twig', [

            'website' => 'Wild Series',

        ]);
    }

   
     #[Route('/show/{id}', methods: ['GET'], requirements: ['id'=>'\d+'], name: 'program_show')] // {page}->parametre ensuite je le passe à ma fonction methode get pour recuperer l'id dans l'url et requirements pour incrementer ++

     public function show(int $id): Response

     {

         return $this->render('program/show.html.twig', ['id' => $id]);

     }
}
