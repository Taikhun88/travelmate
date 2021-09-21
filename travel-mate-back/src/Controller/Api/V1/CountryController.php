<?php

namespace App\Controller\Api\V1;

use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * Page affichant la liste des pays
     * 
     * URL: /api/v1/country
     * Nom de la route : api_v1_country
     * 
     * @Route("/api/v1/country", name="api_v1_country", methods={"GET"})
     */
    public function index(CountryRepository $countryRepository): Response
    {
        // On affiche seulement la liste des pays pour qu'elle soit visible dans la searchbar. 

        $countryList = $countryRepository->findAll();
        //dd($countryList);

        return $this->render('api/v1/country/index.html.twig', [
            'countriesList' => $countryList,
        ]);
    }
}
