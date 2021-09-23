<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CallApiService;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CallApiService $callApiService): Response
    {
        //dd($callApiService->getCitiesData());
        $countriesData = $callApiService->getCountriesData();
        //dd($countriesData);

        foreach ($countriesData as $country) {
            $countryId = $country['id'];
            //dump($countryId);
        }
        
        return $this->render('home/index.html.twig', [
            'countries' => $countriesData
        ]);

    }
}
