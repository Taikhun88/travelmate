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
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('backoffice_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
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
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {

        // Cette méthode va permettre de décider si on peut accéder
        // à la page d'édition d'un utilisateur
        // La logique autorisant ou non l'accès se fera dans le voter UserVoter

        //$this->denyAccessUnlessGranted('USER_EDIT', $user, "Vous ne passerez paaaaas !");
        //dd($user);
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

            return $this->redirectToRoute('backoffice_user_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('backoffice/user/edit.html.twig', [
            
            'user' => $user,
            'form' => $form,
        ]);

    }

    /**
     * Action permettant la suppression d'une catégorie
     *
     * URL : /backoffice/category/{id}/delete
     * Route : backoffice_user_delete
     * 
     * @Route("/{id}/delete", name="delete")
     * 
     * @return Response
     */
    public function delete(int $id, UserRepository $userRepository)
    {
        // On supprime la catégorie en BDD
        $user = $userRepository->find($id);
        //dd($user);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        // Message flash
        $this->addFlash('info', 'L\'utilisateur ' . $user->getNickname() . ' a bien été supprimée');

        return $this->redirectToRoute('backoffice_user_index');
    }
}