<?php

// Chargement des dépendances PHP
require_once '../vendor/autoload.php';

// Chargement du Router
require_once '../core/Router.php';

// Instancier notre routeur afin de rediriger notre utilisateur
$router = new Router();

// Nos routes
$router->add('/', 'HomeController', 'index');
$router->add('/contact', 'HomeController', 'contact');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);
