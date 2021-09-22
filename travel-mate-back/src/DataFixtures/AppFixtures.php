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
        // we call the Faker
        $faker = \Faker\Factory::create();

        // terminal message
        print "Création des users en cours ...";
        $usersObjectList = [];

        // ! USER

        // we create data to add to the User table.
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

        // ! CATEGORY
        // we create data to add to the Category table.
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
        // ! EVENT

        print 'Création des évènements en cours...';

        // we create data to add to the Event table.
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
            $event->setCreator($usersObjectList[mt_rand(0,5)]);

            // ! Association between category and event
            // we add one category associate to one event
            for ($index = 0; $index < 1; $index++) {
                $event->addCategory($categoryObjectList[mt_rand(0,5)]);
            }

            // ! Association between category and event
            // we add some users associate to one event
            for ($index = 0; $index < mt_rand(0,5); $index++) {
                $event->addUser($usersObjectList[$index]);
            }


            // we save the events
            $manager->persist($event);
        }

        // we send all the datas to the database
        $manager->flush();
    }
}
