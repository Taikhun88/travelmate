<?php

namespace App\Controller\Api\V1;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * @Route("/api/v1/registration", name="api_v1_")
 */
class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
        //dd($this->emailVerifier);
    }

    /**
     * method to create a new user
     * 
     * URL : /api/v1/registration
     * Route : api_v1_registration
     *
     * @Route("/", name="registration", methods={"POST"})
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

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
        (new TemplatedEmail())
            ->from(new Address('travel.mate.demo2021@gmail.com', 'Travel Mate'))
            ->to($user->getEmail())
            ->subject('Please Confirm your Email')
            ->htmlTemplate('registration/confirmation_email.html.twig')
    );

        return $this->json($user, 201, [], [
            'groups' => 'user_add'
        ]);
    }

}
