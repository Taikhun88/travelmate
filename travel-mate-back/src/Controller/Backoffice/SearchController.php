<?php

namespace App\Controller\Backoffice;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/backoffice/search", name="backoffice_search")
     */
    public function index(CategoryRepository $categoryRepository, EventRepository $eventRepository, Request $request): Response
    {
        // we get the categories list from the database
        $categoriesList = $categoryRepository->findAll();

        // we get the search input content
        $query = $request->query->get('search');

        // we get the select content 
        $category = $request->query->get('category');

        // if category is empty, we send a enpty string to the method
        if (empty($category)) {
            $category='';
        }

        // 2) we get all the matching results
        $results = $eventRepository->searchEventByCity($query, $category);



        return $this->render('backoffice/search/index.html.twig', [
            'results' => $results,
            'query' => $query,
            'categories' => $categoriesList
        ]);
    }
}
