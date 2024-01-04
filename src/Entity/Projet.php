<?php

namespace App\Entity;

class Projet
{
    private int $id;
    private string $title;
    private string $description;
    private string $preview;
    private string $createdAt;
    private string $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPreview(): string
    {
        // Si l'image n'existe pas, j'en attribue une par défaut
        return (!file_exists($_ENV['FOLDER_PROJECT'] . $this->preview))
            ? 'default.png'
            : $this->preview
        ;
    }

    /**
     * Retourne le chemin complet de l'image du projet
     */
    public function getFolderPreview(): string
    {
        return $_ENV['FOLDER_PROJECT'] . $this->getPreview();
    }

    public function setPreview(string $preview): void
    {
        $this->preview = $preview;
    }

    public function getCreatedAt(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->createdAt);
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function jsonSerialize(): array
    {
        $project = get_object_vars($this);
        $project['folderPreview'] = $this->getFolderPreview();

        return $project;
    }
}
