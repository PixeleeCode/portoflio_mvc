<?php

namespace App\Controller;

use Faker;
use App\Entity\Projet;
use App\Repository\ProjetRepository;

/**
 * Génère des fausses données pour le développement
 */
class FixtureController extends AbstractController
{
    public function index(): void
    {
        $faker = Faker\Factory::create();
        $projetRepository = new ProjetRepository();

        for ($i = 0; $i < 10; $i++) {
            // Créer un objet avec l'entité "Projet"
            $projet = new Projet();
            $projet->setTitle($faker->sentences);
            $projet->setDescription($faker->realText);
            $projet->setPreview('test.png');
            $projet->setCreatedAt($faker->dateTimeBetween('-2 years')->format('Y-m-d'));
            $projet->setUpdatedAt($faker->dateTimeBetween('-1 year')->format('Y-m-d'));

            // Insérer en base de données
            $projetRepository->add($projet);
        }
    }
}
