<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste des auteurs
        $authors = [
            ['firstName' => 'John', 'lastName' => 'Doe'],
            ['firstName' => 'Jane', 'lastName' => 'Smith'],
            ['firstName' => 'Robert', 'lastName' => 'Johnson'],
            ['firstName' => 'Emily', 'lastName' => 'Davis'],
            ['firstName' => 'Michael', 'lastName' => 'Brown'],
        ];

        foreach ($authors as $authorData) {
            $author = new Author();
            $author->setFirstName($authorData['firstName']);
            $author->setLastName($authorData['lastName']);

            $manager->persist($author);
        }

        $manager->flush();
    }
    
}
