<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use App\Service\UploadService;

class AdminController extends AbstractController
{
    public function __construct()
    {
        /**
         * Si l'utilisateur n'est pas connecté, on le redirige
         * vers le formulaire de connexion
         */
        if (!$this->isUserLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }

    /**
     * Accueil de l'administration
     */
    public function index(): void
    {
        // Sélection de tous les articles
        $projetRepository = new ProjetRepository();

        $this->view('admin/index.php', [
            'projects' => $projetRepository->findAll()
        ]);
    }

    /**
     * Nouveau projet
     */
    public function add(): void
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des données
            $title = htmlspecialchars(strip_tags($_POST['title']));
            $description = htmlspecialchars(strip_tags($_POST['description']));

            // Vérifie si tous est bien rempli
            if (
                !empty($title) &&
                !empty($description) &&
                $_FILES['preview']['error'] === UPLOAD_ERR_OK
            ) {
                // Upload de l'image de preview
                $uploadService = new UploadService();
                $preview = $uploadService->upload($_FILES['preview']);

                if ($preview) {
                    // Date du jour
                    $date = new \DateTime();

                    // Créer un objet avec l'entité "Projet"
                    $projet = new Projet();
                    $projet->setTitle($title);
                    $projet->setDescription($description);
                    $projet->setPreview($preview);
                    $projet->setCreatedAt($date->format('Y-m-d H:i:s'));
                    $projet->setUpdatedAt($date->format('Y-m-d H:i:s'));

                    $projetRepository = new ProjetRepository();
                    $projetRepository->add($projet);

                    $success = 'Votre nouveau projet est enregistré';
                } else {
                    $error = 'Le fichier est invalide';
                }
            } else {
                $error = 'Tous les champs sont obligatoires';
            }
        }

        $this->view('admin/project/add.php', [
            'error' => $error,
            'success' => $success
        ]);
    }
}
