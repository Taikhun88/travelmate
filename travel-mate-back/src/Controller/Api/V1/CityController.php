<?php

namespace App\Controller\Api\V1;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * Page affichant la liste des pays
     * 
     * URL: /api/v1/city
     * Nom de la route : api_v1_city
     * 
     * @Route("/api/v1/city", name="api_v1_city", methods={"GET"})
     */
    public function index(CityRepository $cityRepository): Response
    {
        // On affiche seulement la liste des pays pour qu'elle soit visible dans la searchbar. 

        $cityList = $cityRepository->findAll();
        dd($cityList);

        return $this->render('api/v1/city/index.html.twig', [
            'citiesList' => $cityList,
        ]);
    }
}
