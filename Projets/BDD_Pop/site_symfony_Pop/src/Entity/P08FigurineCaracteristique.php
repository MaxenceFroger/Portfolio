<?php

namespace App\Entity;

use App\Repository\P08FigurineCaracteristiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'p08_figurinecaracteristique')]
#[ORM\Entity(repositoryClass: P08FigurineCaracteristiqueRepository::class)]
class P08FigurineCaracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: Types::BIGINT)]
    #[Assert\NotBlank([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    #[Assert\PositiveOrZero(
        message: 'La référence doit être positive.',
    )]
    private ?int $figurine_reference = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    private ?string $figurine_nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    private ?string $figurine_personnage = null;

    #[ORM\Column]
    #[Assert\NotBlank([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    #[Assert\PositiveOrZero(
        message: 'La taille doit être positive.',
    )]
    #[Assert\NotNull([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    private ?int $figurine_taille = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $figurine_date_sortie = null;

    #[ORM\Column]
    #[Assert\NotBlank([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    #[Assert\PositiveOrZero(
        message: 'Le POPID doit être positif.',
    )]
    #[Assert\NotNull([
        'message' => 'Le champ ne peut pas être vide.'
    ])]
    #[Assert\Type(
        type: 'integer',
        message: 'Le POPID doit être un nombre entier.',
    )]
    private ?int $figurine_popid = null;

    #[ORM\Column]
    private ?bool $figurine_chase = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "collection_id", referencedColumnName: "collection_id", nullable: false)]
    private ?P08Collection $collection_id = null;

    public function getFigurineReference(): ?string
    {
        return $this->figurine_reference;
    }

    public function setFigurineReference(string $figurine_reference): static
    {
        $this->figurine_reference = $figurine_reference;
        return $this;
    }

    public function getFigurineNom(): ?string
    {
        return $this->figurine_nom;
    }

    public function setFigurineNom(string $figurine_nom): static
    {
        $this->figurine_nom = $figurine_nom;

        return $this;
    }

    public function getFigurinePersonnage(): ?string
    {
        return $this->figurine_personnage;
    }

    public function setFigurinePersonnage(string $figurine_personnage): static
    {
        $this->figurine_personnage = $figurine_personnage;

        return $this;
    }

    public function getFigurineTaille(): ?int
    {
        return $this->figurine_taille;
    }

    public function setFigurineTaille(int $figurine_taille): static
    {
        $this->figurine_taille = $figurine_taille;

        return $this;
    }

    public function getFigurineDateSortie(): ?\DateTimeInterface
    {
        return $this->figurine_date_sortie;
    }

    public function setFigurineDateSortie(\DateTimeInterface $figurine_date_sortie): static
    {
        $this->figurine_date_sortie = $figurine_date_sortie;

        return $this;
    }

    public function getFigurinePopid(): ?int
    {
        return $this->figurine_popid;
    }

    public function setFigurinePopid(int $figurine_popid): static
    {
        $this->figurine_popid = $figurine_popid;

        return $this;
    }

    public function isFigurineChase(): ?bool
    {
        return $this->figurine_chase;
    }

    public function setFigurineChase(bool $figurine_chase): static
    {
        $this->figurine_chase = $figurine_chase;

        return $this;
    }

    public function getCollectionId(): ?P08Collection
    {
        return $this->collection_id;
    }

    public function setCollectionId(?P08Collection $collection_id): static
    {
        $this->collection_id = $collection_id;

        return $this;
    }
}
