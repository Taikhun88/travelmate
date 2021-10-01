<?php

namespace App\Controller\Backoffice;

use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class SendEmailController extends AbstractController
{
    /**
     * @Route("/backoffice/send/email", name="backoffice_send_email")
     */
    public function sendRegisterConfirmation(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('travel.mate.demo2021@gmail.com')
            ->to('travel.mate.demo2021@gmail.com')
            ->subject('Votre test de confirmation d\'inscription par mail')
            ->html('<p>Bonjour, Vous venez de créer un compte sur notre site. Afin d\'activer ce dernier, il ne vous reste plus qu\'à confirmer en cliquant sur le lien ci-dessous. Si vous n\êtes pas à l\'origine de cette action, nous vous prions de nous le signaler. Cordialement. L\équipe Travel Mate</p>');

            $mailer->send($email);

        return $this->render('backoffice/send_email/index.html.twig', [
            'controller_name' => 'SendEmailController',
        ]);
    }
}
