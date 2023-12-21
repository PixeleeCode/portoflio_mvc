<?php

namespace App\Repository;

use App\Entity\Projet;
use Core\Database;

/**
 * ProjetRepository.php
 */
class ProjetRepository extends Database
{
    private $instance;

    public function __construct()
    {
        $this->instance = self::getInstance();
    }

    /**
     * Insertion en base de données
     */
    public function add(Projet $projet): Projet
    {
        $query = $this->instance->prepare("
            INSERT INTO projets (title, description, preview, created_at, updated_at)
            VALUES (:title, :description, :preview, :created_at, :updated_at)
        ");

        $query->bindValue(':title', $projet->getTitle());
        $query->bindValue(':description', $projet->getDescription());
        $query->bindValue(':preview', $projet->getPreview());
        $query->bindValue(':created_at', $projet->getCreatedAt());
        $query->bindValue(':updated_at', $projet->getUpdatedAt());
        $query->execute();

        // Récupère l'ID nouvellement créé
        $id = $this->instance->lastInsertId();

        // Ajoute l'ID à mon objet
        $projet->setId($id);

        // Retourne notre objet muni d'un ID
        return $projet;
    }
}
