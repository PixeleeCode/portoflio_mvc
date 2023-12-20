<?php

/**
 * Permet de rediriger l'utilisateur selon une adresse personnalisée
 */
class Router {

    public function dispatch(string $uri = '/'): void
    {
        var_dump($uri);
    }
}
