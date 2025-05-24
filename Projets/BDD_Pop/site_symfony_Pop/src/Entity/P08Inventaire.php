<?php

namespace App\Entity;

use App\Repository\P08InventaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: P08InventaireRepository::class)]
class P08Inventaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $figurine_id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(
        type: 'float',
        message: 'La valeur {{ value }}  {{ type }}.',
    )]
    #[Assert\PositiveOrZero(
        message: 'Le prix doit être positif.',
    )]
    private ?float $figurine_prix = null;

    #[ORM\Column]
    private ?bool $figurine_est_possedee = null;

    #[ORM\Column]
    private ?bool $figurine_echangeable = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $figurine_date_acquisition = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(name: 'figurine_reference',referencedColumnName: "figurine_reference", nullable: false)]
    private ?P08FigurineCaracteristique $figurine_reference = null;

    public function getFigurineId(): ?int
    {
        return $this->figurine_id;
    }

    public function getFigurinePrix(): ?float
    {
        return $this->figurine_prix;
    }

    public function setFigurinePrix(float $figurine_prix): static
    {
        $this->figurine_prix = $figurine_prix;

        return $this;
    }

    public function isFigurineEstPossedee(): ?bool
    {
        return $this->figurine_est_possedee;
    }

    public function setFigurineEstPossedee(bool $figurine_est_possedee): static
    {
        $this->figurine_est_possedee = $figurine_est_possedee;

        return $this;
    }

    public function isFigurineEchangeable(): ?bool
    {
        return $this->figurine_echangeable;
    }

    public function setFigurineEchangeable(bool $figurine_echangeable): static
    {
        $this->figurine_echangeable = $figurine_echangeable;

        return $this;
    }

    public function getFigurineDateAcquisition(): ?\DateTimeInterface
    {
        return $this->figurine_date_acquisition;
    }

    public function setFigurineDateAcquisition(?\DateTimeInterface $figurine_date_acquisition): static
    {
        $this->figurine_date_acquisition = $figurine_date_acquisition;

        return $this;
    }

    public function getFigurineReference(): ?P08FigurineCaracteristique
    {
        return $this->figurine_reference;
    }

    public function setFigurineReference(?P08FigurineCaracteristique $figurine_reference): static
    {
        $this->figurine_reference = $figurine_reference;

        return $this;
    }
}
