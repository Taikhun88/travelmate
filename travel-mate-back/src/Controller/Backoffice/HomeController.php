<?php

namespace App\Controller\Backoffice;

use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CallApiService;

class HomeController extends AbstractController
{
    /**
     * @Route("/backoffice/", name="backoffice_home")
     */
    public function index(CallApiService $callApiService, CountryRepository $countryRepository): Response
    {
        // //dd($callApiService->getCitiesData());
        // $countriesData = $callApiService->getCountriesData();
        // //dd($countriesData);

        // $countriesList = $countryRepository->findAll();
        // // dump($countriesList);
        

        // // $cities = $callApiService->getCitiesData($); 
        // // dd($countriesData, $cities);

        // foreach ($countriesList as $country) {
        //     $cities = $callApiService->getCitiesData($country->getCountryCode()); 
        //     dump($cities);
        // }

        $welcome = "Bienvenue sur le backoffice de Travel Mate";

        return $this->render('/backoffice/home/index.html.twig', [
            'welcome_message' => $welcome
        ]);

    }
}