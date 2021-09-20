<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {

        // Appel du composant "Faker"
        $faker = Faker\Factory::create();

        // Création de 10 users,
        // Chaque propriété est remplie grâce au Faker
        for ($nbUsers=1; $nbUsers < 10; $nbUsers++) { 
            $user = new User;

            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setUsername($faker->userName);
            $user->setAge($faker->numberBetween(18, 30));
            $user->setEmail($faker->email);
            $user->setNationality($faker->country);
            $user->setLanguage($faker->languageCode);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'motdepasse'
                )
            );

            // on sauvegarde les données
            $manager->persist($user);

            print "user : " . $user->getFirstname() . $user->getLastname() . " : OK \n" ;
        }

        // on envoi les nouveaux utilisateurs en Bdd
        $manager->flush();
    }
}
