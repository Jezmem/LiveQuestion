<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste des auteurs
        $users = [
            ['username' => 'Jezmem', 'email' => 'tomzarb98@gmail.com', 'password' => 'kk'],
            ['username' => 'TWhiteShadow', 'email' => 'raphael.t.hendrick@gmail.com', 'password' => 'kk'],
            ['username' => 'Galeih', 'email' => 'florian.sauvage.etudiant@gmail.com', 'password' => 'kk'],
            ['username' => 'Magiks', 'email' => 'dupaslucas8@gmail.com', 'password' => 'kk'],
            ['username' => 'Okinest', 'email' => 'theoalleaume@gmail.com', 'password' => 'kk'],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
