<?php

namespace App\Controller\Api\V1;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/city", name="api_v1_city_")
 */
class CityController extends AbstractController
{
    /**
     * Page affichant la liste des villes avec la méthode GET
     * 
     * URL: /api/v1/city
     * Nom de la route : api_v1_city_index
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CityRepository $cityRepository): Response
    {
        // On affiche seulement la liste des pays pour qu'elle soit visible dans la searchbar, si on clique sur un dropdown

        $cityList = $cityRepository->findAll();
        //dd($cityList);

        return $this->json($cityList, 200, [], [
            'groups' => 'cities_list'
        ]);

        // return $this->render('api/v1/city/index.html.twig', [
        //     'citiesList' => $cityList,
        // ]);
    }

    /**
     * Affiche les villes selon un ID
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function show(int $id, CityRepository $cityRepository)
    {
        // On récupère une série en fonction de son id
        $city = $cityRepository->find($id);

        // Si la série n'existe pas, on retourne une erreur 404
        if (!$city) {
            return $this->json([
                'error' => 'La ville saisie ' . $id . ' n\'existe pas'
            ], 404);
        }

        // On retourne le résultat au format JSON
        return $this->json($city, 200, [], [
            'groups' => 'city_show'
        ]);
    }




}
