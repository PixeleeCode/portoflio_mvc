<?php

// Chargement des dépendances PHP
require_once '../vendor/autoload.php';

// Chargement des variables d'environnements
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ .'/../');
$dotenv->load();

// Chargement du Router
require_once '../core/Router.php';

// Instancier notre routeur afin de rediriger notre utilisateur
$router = new Router();

// Nos routes
$router->add('/', 'HomeController', 'index');
$router->add('/contact', 'HomeController', 'contact');
$router->add('/fixtures', 'FixtureController', 'index');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);
