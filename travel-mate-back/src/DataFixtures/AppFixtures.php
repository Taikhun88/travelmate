<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        print "Création des users en cours ...";
        $usersObjectList = [];

        // ! USER

        for ($i = 0; $i < 10; $i++) {

            $users = new User();
            $age = mt_rand(18, 40);

            $users->setLastname($faker->lastName);
            $users->setFirstname($faker->firstName);
            $users->setNickname($faker->userName);
            $users->setImage($faker->image);
            $users->setAge($age);
            $users->setEmail($faker->email);
            $users->setNationality("French");
            $users->setLanguage("Gaulois");     
            $users->setPassword(
                $this->passwordHasher->hashPassword(
                    $users,
                    $faker->password
                ));   
            $users->setCreatedAt(new DateTimeImmutable());    
            $usersObjectList[] = $users;
            
            $manager->persist($users);
        }  

        // ! EVENT

        print 'Création des évènements en cours...';

        for ($nbEvents=1; $nbEvents < 10; $nbEvents++) { 
            $event = new Event;
            $status = mt_rand(0,2);


            $event->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true));
            $event->setImage($faker->image());
            $event->setContent($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
            $event->setResume($faker->sentence($nbWords = 6, $variableNbWords = true));
            $event->setParticipant($faker->numberBetween(0, 10));
            $event->setStartAt(new DateTimeImmutable);
            if ($status = 0) {
                $event->setStatus('à venir');
            } elseif ($status = 1) {
                $event->setStatus('en cours');
            } else {
                $event->setStatus('terminé');
            }
            
            // ! CATEGORY

            $categories = [

                'sport',
                'culture',
                'restaurant',
                'festif',
                'rencontre',
                'nature',
                'entraide',
            ];

            print 'Création des catégories en cours ...';
            $categoryObjectList = [];
            foreach ($categories as $categoryName ) {
                $category = new Category;
                $category->setName($categoryName);
                $category->setImage($faker->image());
                $categoryObjectList[] = $category;
                $manager->persist($category);
            }

            // ! Association de catégorie et event
            // On associe l'event à 1 catégorie
            for ($index = 0; $index < 1; $index++) {
                // dd($categoryObjectList[$index]);
                $event->addCategory($categoryObjectList[$index]);
            }

            // ! Association de user et event
            // On associe à l'event 1 user (le créateur de l'évenement)
            for ($index = 0; $index < 1; $index++) {
                $event->addUser($usersObjectList[$index]);
            }

            // on sauvegarde les données
            $manager->persist($event);
        }

        // on envoi les nouvelles données en Bdd
        $manager->flush();
    }
}
