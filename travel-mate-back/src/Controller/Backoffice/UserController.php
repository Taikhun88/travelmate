<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/backoffice/user", name="backoffice_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        //dump($users);
        return $this->render('backoffice/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * Display details of a user and buttons to edit or delete profile
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('backoffice/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Check if form has been submitted and check if content typed is valid
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Cette méthode va permettre de décider si on peut accéder
        // à la page d'édition d'un utilisateur
        // La logique autorisant ou non l'accès se fera dans le voter UserVoter

        //$this->denyAccessUnlessGranted('USER_EDIT', $user, "Vous ne passerez paaaaas !");

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A la création d'un utilisateur
            // on va hasher le mot de passe saisi en clair
            // dans le formulaire
            // if ($form->has('plainPassword')) {
            //     $user->setPassword(
            //         $passwordHasher->hashPassword(
            //             $user,
            //             $form->get('plainPassword')->getData()
            //         )
            //     );
            // }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }
}
