<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
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
                'password' => 'kk',
                'firstName' => 'Tom',
                'lastName' => 'Zarb',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'username' => 'TWhiteShadow',
                'email' => 'raphael.t.hendrick@gmail.com',
                'password' => 'kk',
                'firstName' => 'Raphael',
                'lastName' => 'Tourssel',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Galeih',
                'email' => 'florian.sauvage.etudiant@gmail.com',
                'password' => 'kk',
                'firstName' => 'Florian',
                'lastName' => 'Sauvage',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Magiks',
                'email' => 'dupaslucas8@gmail.com',
                'password' => 'kk',
                'firstName' => 'Lucas',
                'lastName' => 'Dupas',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Okinest',
                'email' => 'theoalleaume@gmail.com',
                'password' => 'kk',
                'firstName' => 'Theo',
                'lastName' => 'Alleaume',
                'roles' => ['ROLE_USER']
            ],
            [
                'username' => 'Yamosai',
                'email' => 'moncet.yannis@gmail.com',
                'password' => 'kk',
                'firstName' => 'Yannis',
                'lastName' => 'Moncet',
                'roles' => ['ROLE_USER']
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);

            // Hachage du mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);

            // Attribution des rôles
            $user->setRoles($userData['roles']);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['first_load'];
    }
}
