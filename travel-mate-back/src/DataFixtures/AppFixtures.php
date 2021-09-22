<?php

namespace App\DataFixtures;

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
        $usersObjectList = [];

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

            print 'Utilisateur : ' . $users->getLastname() . ' : OK';
          }  

        $manager->flush();
    }
}
