<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [

            'categories' => $categories,

        ]);
    }
     #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
    // Create the associated Form
    $form = $this->createForm(CategoryType::class, $category);
    // Get data from HTTP request
    $form->handleRequest($request);
    // Was the form submitted ?
    if ($form->isSubmitted()) {
        $categoryRepository->save($category, true);
        // Deal with the submitted data
        // For example : persiste & flush the entity
        // And redirect to a route that display the result
        return $this->redirectToRoute('category_index');
    }
    // Render the form
    return $this->renderForm('category/new.html.twig', [

        'form' => $form,

    ]);

        // Alternative
        // return $this->render('category/new.html.twig', [
        //   'form' => $form->createView(),
        // ]);
    }

    #[Route('/show/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository  $categoryRepository, ProgramRepository $programRepository): Response

    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]); // je récupère le name du tableau catégory

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : ' . $category . ' found in category\'s table.'
            );
        }

        $categoryId = $category->getId();
        $programs = $programRepository->findBy(
            ['category' => $categoryId],
            ['id' => 'DESC'],
            3

        );
        return $this->render('category/show.html.twig', [

            'programs' => $programs,
        ]);
    }
}
