<?php

namespace App\Controller;

/**
 * Gestion de l'authentification
 */
class AuthController extends AbstractController
{
    /**
     * Connexion à l'administration
     */
    public function login()
    {
        $this->view('auth/login.php');
    }
}
