<?php

class HomeController
{
    /**
     * Page d'accueil
     */
    public function index(): void
    {
        require_once '../templates/home/index.php';
    }

    /**
     * Page de test
     */
    public function test(): void
    {
        require_once '../templates/home/test.php';
    }
}
