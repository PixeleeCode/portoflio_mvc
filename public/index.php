<?php

require_once '../core/Router.php';

// Instancier notre routeur afin de rediriger notre utilisateur
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
