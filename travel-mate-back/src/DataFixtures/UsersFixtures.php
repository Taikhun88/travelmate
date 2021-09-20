<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UsersFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create();

        for ($nbUsers=1; $nbUsers < 10; $nbUsers++) { 
            $user = new User;

            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setUsername($faker->userName);
            $user->setAge($faker->numberBetween(18, 30));
            $user->setEmail($faker->email);
            $user->setNationality($faker->country);
            $user->setLanguage($faker->languageCode);
            $user->setPassword($faker->password);

            $manager->persist($user);

            print "user : " . $user->getFirstname() . $user->getLastname() . " : OK \n" ;
        }

        $manager->flush();
    }
}
