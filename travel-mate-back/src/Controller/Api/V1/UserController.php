<?php

namespace App\Controller\Api\V1;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/user", name="api_v1_user_", methods={"GET"})
 */
class UserController extends AbstractController
{
    /**
     * method to get the user list
     * 
     * URL : /api/v1/user/
     * Route : api_v1_user_index
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        // we get the user list from the database
        $users = $userRepository->findAll();

        // we return the list to the Json format
        return $this->json($users, 200, [], [
            'groups' => 'user_list'
        ]);
    }

    /**
     * method to get a user by his id
     * 
     * URL : /api/v1/user/{id}
     * Route : api_v1_user_show
     *
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function show(int $id, UserRepository $userRepository)
    {
        // we get the user by the id
        $user = $userRepository->find($id);

        // if the user doesn't exist, we return a 404
        if (!$user) {
            return $this->json([
                'error' => 'L\'évènement ' . $id . ' n\'existe pas'
            ], 404);
        }

        // we return the user to the Json format
        return $this->json($user, 200, [], [
            'groups' => 'user_show'
        ]);
    }
}
