<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Technologie',
            'Santé',
            'Éducation',
            'Sport',
            'Culture',
            'Cinéma'
        ];

        foreach ($categories as $name) {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
        }
        $manager->flush();
    }

}
