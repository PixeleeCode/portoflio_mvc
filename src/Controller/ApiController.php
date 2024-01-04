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
}
