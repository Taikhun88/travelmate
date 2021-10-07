<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        // dd($user);

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['data'] = array(
        'roles' => $user->getRoles(),
        'username' => $user->getUserIdentifier(),
        'id' => $user->getId(),
        'firstname' => $user->getFirstname(),
        'lastname' => $user->getLastname(),
        'nickname' => $user->getNickname(),
        'age' => $user->getAge(),
        'nationality' => $user->getNationality(),
        'language' => $user->getLanguage(),
        'IsVerified' => $user->isVerified(),
        );

        $event->setData($data);
    }
}