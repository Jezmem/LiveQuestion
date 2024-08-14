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
            ['username' => 'Jezmem', 'email' => 'tomzarb98@gmail.com', 'password' => 'kk', 'first_name' => 'Tom', 'last-name' => 'Zarb'],
            ['username' => 'TWhiteShadow', 'email' => 'raphael.t.hendrick@gmail.com', 'password' => 'kk', 'first_name' => 'Raphael', 'last-name' => 'Tourssel'],
            ['username' => 'Galeih', 'email' => 'florian.sauvage.etudiant@gmail.com', 'password' => 'kk', 'first_name' => 'Florian', 'last-name' => 'Sauvage'],
            ['username' => 'Magiks', 'email' => 'dupaslucas8@gmail.com', 'password' => 'kk', 'first_name' => 'Lucas', 'last-name' => 'Dupas'],
            ['username' => 'Okinest', 'email' => 'theoalleaume@gmail.com', 'password' => 'kk', 'first_name' => 'Theo', 'last-name' => 'Alleaume'],
            ['username' => 'Yamosai', 'email' => 'moncet.yannis@gmail.com', 'password' => 'kk', 'first_name' => 'Yannis', 'last-name' => 'Moncet'],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
            $user->setFirstName($userData['first_name']);
            $user->setLastName($userData['last-name']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
