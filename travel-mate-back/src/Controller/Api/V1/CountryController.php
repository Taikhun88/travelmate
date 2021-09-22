<?php

namespace App\Controller\Api\V1;

use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/country", name="api_v1_country_")
 */
class CountryController extends AbstractController
{
    /**
     * Page affichant la liste des pays
     * 
     * URL: /api/v1/country
     * Nom de la route : api_v1_country_index
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CountryRepository $countryRepository): Response
    {
        // On affiche seulement la liste des pays pour qu'elle soit visible dans la searchbar si dropdown 

        $countryList = $countryRepository->findAll();
        //dd($countryList);

        // les groups seront utiles si on a besoin plus tard d'ajouter la création, modification des pays. Les annotations groups ont été ajoutés aux properties du country repo dans cette éventualité
        return $this->json($countryList, 200, [], [
            'groups' => 'countries_list'
        ]);
    }

    /**
     * Affiche les pays selon un ID
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function show(int $id, CountryRepository $countryRepository)
    {
        // On récupère une série en fonction de son id
        $country = $countryRepository->find($id);

        // Si la série n'existe pas, on retourne une erreur 404
        if (!$country) {
            return $this->json([
                'error' => 'Le pays saisi ' . $id . ' n\'existe pas. Vérifiez votre saisie.'
            ], 404);
        }

        // On retourne le résultat au format JSON
        return $this->json($country, 200, [], [
            'groups' => 'country_show'
        ]);
    }
}
