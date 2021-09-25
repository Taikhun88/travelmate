<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This is for grouping routes in the methods below. It acts as the suffix of the routes
 * 
 * @Route("/backoffice/event", name="backoffice_event_")
 */
class EventController extends AbstractController
{
    /**
     * Displays a list of Events in our database by using the method GET throught EventRepository
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {   
        // This method puts lists data in a JSON array
        $events = $eventRepository->findAll();

        // Displays all data on the twig thanks to the variable events
        return $this->render('backoffice/event/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * Allows to create a new event thnaks to a form. The form created with command make:form is linked to Event.php
     * 
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // We call the Request class to get the HTTP request sent through the submit in form
        // then we proceed the instanciation of Event to start filling content form with it
        // if any need to display more or less details, EventType can be set up to match expectactions
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        // handleRequest enables to check that content of form is filled the way we want it
        $form->handleRequest($request);
        
        // isSubmitted checks existence of content in all input of Form
        // then isValid checks that content matches the settings we code. 
        // They need to be absolute 2 conditions confirmed before receiving request to avoid any attempt of hack. NTUI
        if ($form->isSubmitted() && $form->isValid()) {

            // $imageFile = $imageUploader->upload($form, 'imgupload');
            // if ($imageFile) {
            //     $event->setImage($imageFile);
            // }

            // $title = $event->getTitle();

            // $slug = $slugger->slug(strtolower($title));

            // $event->setTitle($slug);

            // entityManager calls the Manager to proceed with pre saving and saving. 
            // Persist is needed here just before Flush as we create new data    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // Displays a message to inform actions is being done successfully    
            $this->addFlash('success', 'L\'événement ' . $event->getTitle() . ' a bien été créé');
            //dd($event);

            // redirectToRoute proceed with redirecting the current page to another page that we specify within parenthesis
            return $this->redirectToRoute('backoffice_event_index', [], Response::HTTP_SEE_OTHER);
        }        
        // Displays a twig form through the use of variables
        return $this->renderForm('backoffice/event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}) 
     */
    public function show(Event $event): Response
    {
        return $this->render('backoffice/event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(int $id, Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eventTitle = $event->getTitle($id);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'event ' . $eventTitle . ' a bien été créé');

            return $this->redirectToRoute('backoffice_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * This allows to delete an event basing on a user ID
     *
     * URL : /backoffice/event/{id}/delete
     * Route : backoffice_event_delete
     * 
     * @Route("/{id}/delete", name="delete")
     * 
     * @return Response
     */
    public function delete(int $id, EventRepository $eventRepository)
    {
        $event = $eventRepository->find($id);
        //dd($event);
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        // Displays a message in case we succeed deleting
        $this->addFlash('info', 'L\'événement ' . $event->getTitle() . ' a bien été supprimée');

        return $this->redirectToRoute('backoffice_event_index');
    }
}