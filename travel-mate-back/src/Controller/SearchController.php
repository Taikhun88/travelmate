<?php

namespace App\Controller;

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
    public function index(CityRepository $cityRepository, EventRepository $eventRepository, Request $request): Response
    {
        $citiesList = $cityRepository->findAll();

        // 1) On récupère le mot-clé saisi dans le formulaire de recherche
        $query = $request->query->get('search');
        // dd($query);

        // 2) On récupère toutes les séries qui contiennent ce mot-clé
        // $results = $eventRepository->searchEventByCity($query);
        // dd($results);



        return $this->render('search/index.html.twig', [
            // 'results' => $results,
            'query' => $query,
            'cities' => $citiesList
        ]);
    }
}
