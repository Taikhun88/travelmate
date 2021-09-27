<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Event;
use App\Entity\User;
use App\Service\CallApiService;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    
    private $passwordHasher;
    private $callApiService;
    public function __construct(UserPasswordHasherInterface $passwordHasher, CallApiService $callApiService)
    {
        $this->passwordHasher = $passwordHasher;
        $this->callApiService = $callApiService;
    }

    public function load(ObjectManager $manager)
    {
        // we call the Faker
        $faker = \Faker\Factory::create();

        // ! COUNTRY & CITY

        $countriesList = $this->callApiService->getCountriesData();
        // dd($countriesList);

        // terminal message
        print "Création des pays et des villes en cours ...";

        $cityObjectList = [];

        foreach ($countriesList as $country) {
            // we create a new object Country
            $newCountry = new Country;
            // we add it these properties
            $newCountry->setName($country['name']);
            $newCountry->setCountryCode($country['id']);
            // we save it
            $manager->persist($newCountry);

            // for each country, we call all the associated cities from the Spott API
            $citiesList = $this->callApiService->getCitiesData($country['id']);

            // we loop on the cities of each country
            foreach ($citiesList as $city) {
                // we create a new object City
                $newCity = new City;
                // We add it these properties
                $newCity->setName($city['name']);
                $newCity->setCountry($newCountry);
                $newCity->setCountryCode($country['id']);  
                // we add the current city in a list to use it to associate one event to one random city  
                $cityObjectList[] = $newCity;
                // we save the new city
                $manager->persist($newCity);
            }
        }

        // terminal message
        print "Création des users en cours ...";

        $usersObjectList = [];

        // ! USER

        // we create data to add to the User table.
        for ($i = 0; $i < 10; $i++) {

            print 'Création du personnage ' . $i . ' en cours ...';
            $user = new User();
            $age = mt_rand(18, 40);

            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setNickname($faker->userName);
            $user->setImage('https://picsum.photos/600/600');
            $user->setAge($age);
            $user->setEmail($faker->email);
            $user->setNationality("French");
            $user->setLanguage("Gaulois");     
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $faker->password
                ));   
            $user->setCreatedAt(new DateTimeImmutable());    
            $usersObjectList[] = $user;
            
            $manager->persist($user);
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
            $category->setImage('https://picsum.photos/600/600');
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
            $event->setImage('https://picsum.photos/600/600');
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
            $event->setCity($cityObjectList[mt_rand(0,99)]);

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
