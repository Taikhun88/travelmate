<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use DateTimeImmutable;

class EventsFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        // Appel du composant "Faker"
        $faker = Faker\Factory::create();

        // Création de 10 users,
        // Chaque propriété est remplie grâce au Faker
        for ($nbEvents=1; $nbEvents < 10; $nbEvents++) { 
            $event = new Event;
            $status = 'à venir';

            $event->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true));
            $event->setContent($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
            $event->setResume($faker->sentence($nbWords = 6, $variableNbWords = true));
            $event->setParticipant($faker->numberBetween(0, 10));
            $event->setStartAt(new DateTimeImmutable);
            $event->setStatus($status);

            // on sauvegarde les données
            $manager->persist($event);

            print "event : " . $event->getTitle() . " : OK \n" ;
        }

        // on envoi les nouveaux utilisateurs en Bdd
        $manager->flush();
    }
}
