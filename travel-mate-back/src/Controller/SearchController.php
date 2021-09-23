<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(CategoryRepository $categoryRepository, EventRepository $eventRepository, Request $request): Response
    {
        $categoriesList = $categoryRepository->findAll();

        // 1) On récupère le mot-clé saisi dans le formulaire de recherche
        $query = $request->query->get('search');
        // dd($query);
        // 1) On récupère le mot-clé saisi dans le formulaire de recherche
        $category = $request->query->get('category');
        if (empty($category)) {
            $category='';
        }

        // 2) On récupère tous les evenements qui contiennent ce mot-clé
        $results = $eventRepository->searchEventByCity($query, $category);
        // dump($results);



        return $this->render('search/index.html.twig', [
            'results' => $results,
            'query' => $query,
            'categories' => $categoriesList
        ]);
    }
}
