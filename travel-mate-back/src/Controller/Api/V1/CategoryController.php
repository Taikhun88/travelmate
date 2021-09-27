<?php

namespace App\Controller\Api\V1;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/category", name="api_v1_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * method to get the category list
     * 
     * URL: /api/v1/country
     * Nom de la route : api_v1_country_index
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        // we get the categories list
        $categories = $categoryRepository->findAll();

        return $this->json($categories, 200, [], [
            'groups' => 'category_list'
        ]);
    }

    /**
     * method to get a category by his id
     * 
     * URL : /api/v1/category/{id}
     * Route : api_v1_category_show
     *
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function show(int $id, CategoryRepository $categoryRepository)
    {
        // we get the category by the id
        $category = $categoryRepository->find($id);

        // if the category doesn't exist, we return a 404
        if (!$category) {
            return $this->json([
                'error' => 'L\'évènement ' . $id . ' n\'existe pas'
            ], 404);
        }

        // we return the category to the Json format
        return $this->json($category, 200, [], [
            'groups' => 'category_show'
        ]);
    }
}
