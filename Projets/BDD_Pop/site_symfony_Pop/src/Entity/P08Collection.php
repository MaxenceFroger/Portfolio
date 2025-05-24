<?php

namespace App\Entity;

use App\Repository\P08CollectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: P08CollectionRepository::class)]
class P08Collection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $collection_id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank([
    'message' => 'Le nom de la collection ne peut pas être vide.'
    ])]
    private ?string $collection_nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    private ?string $collection_licence = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    private ?string $collection_categorie = null;

    public function getCollectionId(): ?int
    {
        return $this->collection_id;
    }

    public function getCollectionNom(): ?string
    {
        return $this->collection_nom;
    }

    public function setCollectionNom(string $collection_nom): static
    {
        $this->collection_nom = $collection_nom;

        return $this;
    }

    public function getCollectionLicence(): ?string
    {
        return $this->collection_licence;
    }

    public function setCollectionLicence(string $collection_licence): static
    {
        $this->collection_licence = $collection_licence;

        return $this;
    }

    public function getCollectionCategorie(): ?string
    {
        return $this->collection_categorie;
    }

    public function setCollectionCategorie(string $collection_categorie): static
    {
        $this->collection_categorie = $collection_categorie;

        return $this;
    }
}
