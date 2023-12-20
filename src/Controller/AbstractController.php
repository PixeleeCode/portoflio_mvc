<?php

namespace App\Controller;

abstract class AbstractController
{
    /**
     * Permet d'afficher une vue
     */
    protected function view(string $path, array $vars = []): void
    {
        /**
         * Extrait les clés comme des variables et affectent comme valeur,
         * la valeur de la clé du tableau
         */
        extract($vars);

        // Si le template existe, on l'affiche
        if (file_exists("../templates/$path")) {
            require_once "../templates/$path";
            return;
        }

        throw new \RuntimeException("Le template \"$path\" n'existe pas");
    }
}
