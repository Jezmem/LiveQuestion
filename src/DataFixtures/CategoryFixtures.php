<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // Liste des catégories
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

    public static function getGroups(): array
    {
        return ['first_load'];
    }
}
