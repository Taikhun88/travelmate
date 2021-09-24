<?php

namespace App\Controller\Api\V1;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/v1/search", name="api_v1_search_")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, Request $request, SerializerInterface $serializer): Response
    {

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

        return $this->json($results, 200);
    }
}
