<?php

namespace App\Controller;

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
        $this->view('admin/index.php');
    }
}
