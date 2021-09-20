<?php

namespace App\Controller\Backoffice;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/event", name="backoffice_event_")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EventRepository $eventRepository): Response
    {

        // Récupération de tous les Events:
        $eventsList = $eventRepository->findAll();
        dump($eventsList);

        return $this->render('backoffice/event/index.html.twig', [
            'controller_name' => 'EventController',
                'eventsList' => $eventsList,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(int $id ,EventRepository $eventRepository): Response
    {

        // Récupération de tous les Events:
        $event = $eventRepository->find($id);
        dump($event);

        return $this->render('backoffice/event/show.html.twig', [
            'controller_name' => 'EventController',
                'event' => $event,
        ]);
    }

    
}
