<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            1 => [
                'name' => 'sport',
                'image' => 'sport.jpeg'
            ],
            2 => [
                'name' => 'culture',
                'image' => 'culture.jpeg'
            ],
            3 => [
                'name' => 'restaurant',
                'image' => 'restaurant.jpeg'
            ],
            4 => [
                'name' => 'festif',
                'image' => 'festif.jpeg'
            ],
            5 => [
                'name' => 'rencontre',
                'image' => 'rencontre.jpeg'
            ],
            6 => [
                'name' => 'nature',
                'image' => 'nature.jpeg'
            ],
            7 => [
                'name' => 'entraide',
                'image' => 'entraide.jpeg'
            ],
        ];

        foreach ($categories as $key => $value) {
            $category = new Category;
            $category->setName($value['name']);
            $category->setImage($value['image']);
            $manager->persist($category);

            print "Catégory : " . $category->getName() . " : OK \n" ;
        }

        $manager->flush();
    }
}
