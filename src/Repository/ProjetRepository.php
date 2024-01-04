<?php

namespace App\Repository;

use App\Entity\Projet;
use Core\Database;

class ProjetRepository extends Database
{
    private \PDO $instance;

    public function __construct()
    {
        $this->instance = self::getInstance();
    }

    /**
     * Supprime en base de données
     */
    public function delete(Projet $projet): Projet
    {
        $query = $this->instance->prepare("DELETE FROM projets WHERE id = :id");
        $query->bindValue(':id', $projet->getId());
        $query->execute();

        return $projet;
    }

    /**
     * Edition en base de données
     */
    public function edit(Projet $projet): Projet
    {
        $query = $this->instance->prepare("
            UPDATE projets SET 
                title = :title, description = :description, preview = :preview,
                created_at = :created_at, updated_at = :updated_at
            WHERE id = :id
        ");

        $query->bindValue(':title', $projet->getTitle());
        $query->bindValue(':description', $projet->getDescription());
        $query->bindValue(':preview', $projet->getPreview());
        $query->bindValue(':created_at', $projet->getCreatedAt()->format('Y-m-d H:i:s'));
        $query->bindValue(':updated_at', $projet->getUpdatedAt());
        $query->bindValue(':id', $projet->getId());
        $query->execute();

        // Retourne notre objet
        return $projet;
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
        $query->bindValue(':created_at', $projet->getCreatedAt()->format('Y-m-d H:i:s'));
        $query->bindValue(':updated_at', $projet->getUpdatedAt());
        $query->execute();

        // Récupère l'ID nouvellement créé
        $id = $this->instance->lastInsertId();

        // Ajoute l'ID à mon objet
        $projet->setId($id);

        // Retourne notre objet muni d'un ID
        return $projet;
    }

    /**
     * Sélectionne tous les projets
     */
    public function findAll(bool $serialize = false): array
    {
        $objectsProjects = [];
        $query = $this->instance->query("SELECT * FROM projets ORDER BY created_at DESC");
        $projects = $query->fetchAll();

        foreach ($projects as $project) {
            $item = new Projet();
            $item->setId($project->id);
            $item->setTitle($project->title);
            $item->setDescription($project->description);
            $item->setPreview($project->preview);
            $item->setCreatedAt($project->created_at);
            $item->setUpdatedAt($project->updated_at);

            $objectsProjects[] = $serialize ? $item->jsonSerialize() : $item;
        }

        return $objectsProjects;
    }

    /**
     * Sélectionne un projet
     */
    public function find(int $id): Projet|bool
    {
        $objectProject = false;

        $query = $this->instance->prepare("SELECT * FROM projets WHERE id = :id");
        $query->bindValue(':id', $id);
        $query->execute();

        $projet = $query->fetch();

        if ($projet) {
            $objectProject = new Projet();
            $objectProject->setId($projet->id);
            $objectProject->setTitle($projet->title);
            $objectProject->setDescription($projet->description);
            $objectProject->setPreview($projet->preview);
            $objectProject->setCreatedAt($projet->created_at);
            $objectProject->setUpdatedAt($projet->updated_at);
        }

        return $objectProject;
    }

    public function search(string $querySearch): array
    {
        $objectProjects = [];
        $query = $this->instance->prepare("
            SELECT * FROM projets 
            WHERE title LIKE :querySearch OR description LIKE :querySearch 
            ORDER BY created_at DESC
        ");

        $query->bindValue(':querySearch', "%$querySearch%");
        $query->execute();

        foreach($query->fetchAll() as $project) {
            $item = new Projet();
            $item->setId($project->id);
            $item->setTitle($project->title);
            $item->setDescription($project->description);
            $item->setPreview($project->preview);
            $item->setCreatedAt($project->created_at);
            $item->setUpdatedAt($project->updated_at);

            $objectProjects[] = $item->jsonSerialize();
        }

        return $objectProjects;
    }

    public function isLove(int $idProjet): void
    {
        $query = $this->instance->prepare("
            INSERT INTO projets_likes (user_id, projet_id) VALUES (:user_id, :projet_id)
        ");

        $query->bindValue(':user_id', $_SESSION['user']->getId());
        $query->bindValue(':projet_id', $idProjet);
        $query->execute();
    }
}
