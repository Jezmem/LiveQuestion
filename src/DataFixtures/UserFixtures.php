<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Liste des utilisateurs avec rôles
        $users = [
            [
                'username' => 'Jezmem',
                'email' => 'tomzarb98@gmail.com',
                'password' => 'Str0ngP4ssw0rd',
                'firstName' => 'Tom',
                'lastName' => 'Zarb',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'username' => 'TWhiteShadow',
                'email' => 'raphael.t.hendrick@gmail.com',
                'password' => 'password',
                'firstName' => 'Raphael',
                'lastName' => 'Tourssel',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Galeih',
                'email' => 'florian.sauvage.etudiant@gmail.com',
                'password' => 'password',
                'firstName' => 'Florian',
                'lastName' => 'Sauvage',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Magiks',
                'email' => 'dupaslucas8@gmail.com',
                'password' => 'password',
                'firstName' => 'Lucas',
                'lastName' => 'Dupas',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Okinest',
                'email' => 'theoalleaume@gmail.com',
                'password' => 'password',
                'firstName' => 'Theo',
                'lastName' => 'Alleaume',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Yamosai',
                'email' => 'moncet.yannis@gmail.com',
                'password' => 'password',
                'firstName' => 'Yannis',
                'lastName' => 'Moncet',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'MentalWorker',
                'email' => 'jacquelotjeff@gmail.com',
                'password' => 'password',
                'firstName' => 'Jeff',
                'lastName' => 'Martins',
                'roles' => ['ROLE_USER']
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);

            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);

            $user->setRoles($userData['roles']);

            $manager->persist($user);
        }

        $manager->flush();
    }

}
