<?php

namespace App\Controller;

use Faker;
use App\Entity\Projet;
use App\Entity\User;
use App\Repository\ProjetRepository;
use App\Repository\UserRepository;

/**
 * Génère des fausses données pour le développement
 */
class FixtureController extends AbstractController
{
    public function index(): void
    {
        $faker = Faker\Factory::create();

        // Insertion de faux projets
        $projetRepository = new ProjetRepository();
        for ($i = 0; $i < 10; $i++) {
            // Créer un objet avec l'entité "Projet"
            $projet = new Projet();
            $projet->setTitle($faker->sentence);
            $projet->setDescription($faker->realText);
            $projet->setPreview('test.png');
            $projet->setCreatedAt($faker->dateTimeBetween('-2 years')->format('Y-m-d'));
            $projet->setUpdatedAt($faker->dateTimeBetween('-1 year')->format('Y-m-d'));

            // Insérer en base de données
            $projetRepository->add($projet);
        }

        // Insertion de faux utilisateurs
        $userRepository = new UserRepository();
        for ($i = 0; $i < 2; $i++) {
            // Créer un objet avec l'entité "User"
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword(password_hash('secret', PASSWORD_DEFAULT));

            // Insérer en base de données
            $userRepository->add($user);
        }

        // Affiche une vue
        $this->view('fixtures/index.php');
    }
}
