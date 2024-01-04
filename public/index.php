<?php

// Chargement des dépendances PHP
require_once '../vendor/autoload.php';

// Démarrage de session
session_start();

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

// Déconnexion
$router->add('/logout', 'AuthController', 'logout');

// Administration - Accueil
$router->add('/admin', 'AdminController', 'index');

// Administration - Ajout d'un projet
$router->add('/admin/new/project', 'AdminController', 'add');

// Administration - Edition d'un projet
$router->add('/admin/edit/project', 'AdminController', 'edit');

// Administration - Suppression d'un projet
$router->add('/admin/delete/project', 'AdminController', 'delete');

// Erreur 404
$router->add('/404', 'ErrorController', 'error404');

/**
 * API Routes
 */
// Retourne tous les projets au format JSON
$router->add('/api/all/projects', 'ApiController', 'loadAllProjects');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);
