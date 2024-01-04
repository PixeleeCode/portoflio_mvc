<?php

/**
 * Méthodes appelées par JavaScript/AJAX
 */
namespace App\Controller;

use App\Repository\ProjetRepository;

class ApiController extends AbstractController
{
    public function __construct()
    {
        // Modifie l'entête pour la réponse HTTP en JSON
        header('Content-Type: application/json');
    }

    /**
     * Retourner tous les projets
     */
    public function loadAllProjects()
    {
        $repository = new ProjetRepository();
        echo json_encode($repository->findAll(true));
    }

    /**
     * Récupérer les infos d'un projet
     */
    public function loadDetailsProject()
    {
        $repository = new ProjetRepository();
        $project = $repository->find($_GET['id']);

        // Erreur 404 ?
        if (!$project) {
            echo json_encode([
                'code' => 404
            ]);
            exit;
        }

        echo json_encode($project->jsonSerialize());
    }
}
