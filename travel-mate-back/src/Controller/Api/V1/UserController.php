<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/user", name="api_v1_user_")
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

    /**
     * method to get a user by his id
     * 
     * URL : /api/v1/user
     * Route : api_v1_user_add
     *
     * @Route("/", name="add", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function add(Request $request, UserPasswordHasherInterface $passwordHasher, SerializerInterface $serialiser, ValidatorInterface $validator): Response
    {


        // 1) we get the JSON
        $jsonData = $request->getContent();

        // 2) we transform the Json to an object
        $user = $serialiser->deserialize($jsonData, User::class, 'json');

        // we hash the password before to send it to the database
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );

        // we validate the object datas with the "Assert" from the User entity
        $errors = $validator->validate($user);

        // if the errors array isn't empty
        if (count($errors) > 0) {
            // Code 400 : bad request 
            return $this->json($errors, 400);
        }

        
        // we save the modification and we send it to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json($user, 201, [], [
            'groups' => 'user_add'
        ]);
    }

    /**
     * method to update an user 
     * 
     * URL : /api/v1/user/
     * Route : api_v1_user_update
     * 
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function update(int $id, UserRepository $userRepository, Request $request, SerializerInterface $serialiser)
    {
        // we get the the datas to the json format
        $jsonData = $request->getContent();

        // we get the user by id
        $user = $userRepository->find($id);

        if (!$user) {
            // if the user to update doesn't exist
            // (400::bad request ou 404:: not found)
            return $this->json(
                [
                    'errors' => [
                        'message' => 'L\'évènement ' . $id . ' n\'existe pas'
                    ]
                ],
                404
            );
        }

        // we ask to the serializer to transform the json datas ($jsonData)
        // to an user object, while merging datas with the existing object $user
        $serialiser->deserialize($jsonData, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        // we call the manager to make the update
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->json($user, 201, [], [
            'groups' => 'user_update',
            'message' => 'l\'évènement ' . $id . ' a bien été modifier'
        ]);
    }

    /**
     * method to delete an user
     * 
     * URL : /api/v1/user/
     * Route : api_v1_user_delete
     * 
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @param integer $id
     * @param UserRepository $UserRepository
     * @return void
     */
    public function delete($id,  UserRepository $userRepository) {
        
        // we get the user to delete
        $userToDelete = $userRepository->find($id);

        // if the user to delete doesn't exist, we return a 404 error
        if (!$userToDelete) {
            return $this->json([
                'error' => 'L\'utilisateur ' . $id . ' n\'existe pas'
            ], 404);
        }

        // we call the manager to save the deletion
        $em = $this->getDoctrine()->getManager();
        $em->remove($userToDelete);
        $em->flush();

        return $this->json($userToDelete, 204, [], [
            'groups' => 'user_delete',
            'message' => 'l\'utilisateur ' . $id . ' a bien été supprimer'
        ]);
    }

}
