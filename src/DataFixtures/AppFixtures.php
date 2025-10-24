<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Status;
use App\Entity\Responsible;
use App\Entity\User;
use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des catégories
        $categories = ['Incident', 'Panne', 'Évolution', 'Anomalie', 'Information'];
        $categoryEntities = [];
        
        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categoryEntities[] = $category;
        }

        // Création des statuts
        $statuses = ['Nouveau', 'Ouvert', 'Résolu', 'Fermé'];
        $statusEntities = [];
        
        foreach ($statuses as $statusName) {
            $status = new Status();
            $status->setName($statusName);
            $manager->persist($status);
            $statusEntities[] = $status;
        }

        // Création des responsables
        $responsibles = [
            ['name' => 'Jean Dupont', 'email' => 'jean.dupont@agence.com'],
            ['name' => 'Marie Martin', 'email' => 'marie.martin@agence.com'],
            ['name' => 'Pierre Durand', 'email' => 'pierre.durand@agence.com']
        ];
        $responsibleEntities = [];
        
        foreach ($responsibles as $responsibleData) {
            $responsible = new Responsible();
            $responsible->setName($responsibleData['name']);
            $responsible->setEmail($responsibleData['email']);
            $manager->persist($responsible);
            $responsibleEntities[] = $responsible;
        }

        // Création de l'administrateur
        $admin = new User();
        $admin->setEmail('admin@agence.com');
        $admin->setName('Administrateur');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        // Création d'un utilisateur personnel
        $staff = new User();
        $staff->setEmail('staff@agence.com');
        $staff->setName('Personnel');
        $staff->setRoles(['ROLE_STAFF']);
        $staff->setPassword($this->passwordHasher->hashPassword($staff, 'staff123'));
        $manager->persist($staff);

        // Création de quelques tickets d'exemple
        $ticketDescriptions = [
            'Mon ordinateur ne démarre plus depuis ce matin. J\'ai essayé de le redémarrer plusieurs fois mais rien ne se passe.',
            'Le site web de l\'entreprise est très lent depuis hier. Les pages mettent plus de 10 secondes à se charger.',
            'Je souhaiterais ajouter une fonctionnalité d\'export des données en PDF dans l\'application.',
            'Il y a une erreur 500 qui apparaît parfois lors de la connexion à l\'espace client.',
            'Pouvez-vous me donner des informations sur les nouvelles fonctionnalités prévues pour le mois prochain ?'
        ];

        for ($i = 0; $i < 5; $i++) {
            $ticket = new Ticket();
            $ticket->setAuthor('client' . ($i + 1) . '@example.com');
            $ticket->setDescription($ticketDescriptions[$i]);
            $ticket->setCategory($categoryEntities[array_rand($categoryEntities)]);
            $ticket->setStatus($statusEntities[array_rand($statusEntities)]);
            $ticket->setResponsible($responsibleEntities[array_rand($responsibleEntities)]);
            
            $manager->persist($ticket);
        }

        $manager->flush();
    }
}
