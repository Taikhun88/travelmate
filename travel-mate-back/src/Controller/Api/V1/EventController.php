<?php

namespace App\Controller\Api\V1;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/event", name="api_v1_event_")
 */
class EventController extends AbstractController
{
    /**
     * method to get the event list
     * 
     * URL : /api/v1/event/
     * Route : api_v1_event_index
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        // we get the event list from the database
        $events = $eventRepository->findAll();

        // we return the list to the Json format
        return $this->json($events, 200, [], [
            'groups' => 'event_list'
        ]);
    }

    /**
     * method to get a event by his id
     * 
     * URL : /api/v1/event/{id}
     * Route : api_v1_event_show
     *
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function show(int $id, EventRepository $eventRepository)
    {
        // we get the event by the id
        $event = $eventRepository->find($id);

        // if the event doesn't exist, we return a 404
        if (!$event) {
            return $this->json([
                'error' => 'L\'évènement ' . $id . ' n\'existe pas'
            ], 404);
        }

        // we return the event to the Json format
        return $this->json($event, 200, [], [
            'groups' => 'event_show'
        ]);
    }

    /**
     * method to add an event to the database
     * 
     * URL : /api/v1/event/
     * Route : api_v1_event_add
     * 
     * @Route("/", name="add", methods={"POST"})
     *
     * @return void
     */
    public function add(Request $request, SerializerInterface $serialiser, ValidatorInterface $validator, UserService $userService)
    {
        // 1) we get the Json
        $jsonData = $request->getContent();

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        // 2) we transform the Json to an object
        $event = $serialiser->deserialize($jsonData, Event::class, 'json');
        $event->setCreator($user);

        // we validate the object datas with the "Assert" from the Event entity
        $errors = $validator->validate($event);
        
        // if the errors array isn't empty
        if (count($errors) > 0) {
            // Code 400 : bad request 
            return $this->json($errors, 400);
        }

        // we save calling the manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        return $this->json($event, 201, [], [
            'groups' => 'event_add'
        ]);
    }

    /**
     * method to update an event 
     * 
     * URL : /api/v1/event/
     * Route : api_v1_event_update
     * 
     * @Route("/{id}", name="update", methods={"PATCH"})
     *
     * @return void
     */
    public function update(int $id, EventRepository $eventRepository, Request $request, SerializerInterface $serialiser)
    {

        // we get the the datas to the json format
        $jsonData = $request->getContent();

        // we get the event by id
        $event = $eventRepository->find($id);

        if (!$event) {
            // if the event to update doesn't exist
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
        // to an Event object, while merging datas with the existing object $event
        $serialiser->deserialize($jsonData, Event::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $event]);

        // we call the manager to make the update
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->json($event, 201, [], [
            'groups' => 'event_update',
            'message' => 'l\'évènement ' . $id . ' a bien été modifier'
        ]);
    }

    /**
     * method to delete an event
     * 
     * URL : /api/v1/event/
     * Route : api_v1_tvshow_delete
     * 
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @param integer $id
     * @param EventRepository $tvShowRepository
     * @return void
     */
    public function delete($id,  EventRepository $eventRepository, Request $request) {
        
        // we get the event to delete
        $eventToDelete = $eventRepository->find($id);

        // if the event to delete doesn't exist, we return a 404 error
        if (!$eventToDelete) {
            return $this->json([
                'error' => 'L\'évènement ' . $id . ' n\'existe pas'
            ], 404);
        }

        if ($this->isCsrfTokenValid('delete'.$eventToDelete->getId(), $request->request->get('_token'))) {
            // we call the manager to save the deletion
            $em = $this->getDoctrine()->getManager();
            $em->remove($eventToDelete);
            $em->flush();
        }

        return $this->json($eventToDelete, 201, [], [
            'groups' => 'event_delete',
            'message' => 'l\'évènement ' . $id . ' a bien été supprimer'
        ]);
    }

    /**
     * method to add a user to an event
     * 
     * @Route("/subscription/{id}", name="addUserToEvent", methods={"PUT"})
     *
     * @param Event $event
     * @return void
     */
    public function addUserToEvent(Event $event) {

        // we get the connected user 
        $user = $this->getUser();

        // we add the connected user to the current event
        $event->addUser($user);

        // we save to the database
        $this->getDoctrine()->getManager()->flush();

        return $this->json($event, 201, [], [
            'groups' => 'event_addUser',
            'message' => 'success', 'Vous vous êtes bien inscrit à l\'évènement ' . $event->getTitle(),
        ]);
    }

    /**
     * method to remove a user from an event
     * 
     * @Route("/removal/{id}", name="removeUserfromEvent", methods={"PUT"})
     *
     * @param Event $event
     * @return void
     */
    public function removeUserfromEvent(Event $event) {

        // we get the connected user 
        $user = $this->getUser();

        // we add the connected user to the current event
        $event->removeUser($user);

        // we save to the database
        $this->getDoctrine()->getManager()->flush();

        return $this->json($event, 201, [], [
            'groups' => 'event_addUser',
            'message' => 'success', 'Vous vous êtes bien désinscrit de l\'évènement ' . $event->getTitle(),
        ]);
    }
}
