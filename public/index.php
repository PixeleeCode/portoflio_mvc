<?php

// Démarrage de session
session_start();

// Chargement des dépendances PHP
require_once '../vendor/autoload.php';

// Chargement des variables d'environnements
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ .'/../');
$dotenv->load();

// Instancier notre routeur afin de rediriger notre utilisateur
$router = new Core\Router();

// Nos routes
// Accueil
$router->add('/', 'HomeController', 'index');

// Formulaire de contact
$router->add('/contact', 'HomeController', 'contact');

// Insertion de données d'essais
$router->add('/fixtures', 'FixtureController', 'index');

// Détail d'un projet
$router->add('/projet/details', 'HomeController', 'details');

// Connexion
$router->add('/login', 'AuthController', 'login');

// Accueil de l'administration
$router->add('/admin', 'AdminController', 'index');

// Erreur 404
$router->add('/404', 'ErrorController', 'error404');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);
