<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // Liste des auteurs
        $users = [
            ['username' => 'Jezmem', 'email' => 'tomzarb98@gmail.com', 'password' => 'kk', 'firstName' => 'Tom', 'lastName' => 'Zarb'],
            ['username' => 'TWhiteShadow', 'email' => 'raphael.t.hendrick@gmail.com', 'password' => 'kk', 'firstName' => 'Raphael', 'lastName' => 'Tourssel'],
            ['username' => 'Galeih', 'email' => 'florian.sauvage.etudiant@gmail.com', 'password' => 'kk', 'firstName' => 'Florian', 'lastName' => 'Sauvage'],
            ['username' => 'Magiks', 'email' => 'dupaslucas8@gmail.com', 'password' => 'kk', 'firstName' => 'Lucas', 'lastName' => 'Dupas'],
            ['username' => 'Okinest', 'email' => 'theoalleaume@gmail.com', 'password' => 'kk', 'firstName' => 'Theo', 'lastName' => 'Alleaume'],
            ['username' => 'Yamosai', 'email' => 'moncet.yannis@gmail.com', 'password' => 'kk', 'firstName' => 'Yannis', 'lastName' => 'Moncet'],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['first_load'];
    }
}
