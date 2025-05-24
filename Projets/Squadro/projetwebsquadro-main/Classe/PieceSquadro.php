<?php

namespace Squadro\Classe;
/**
 * Classe représentant une pièce ou une case du jeu Squadro.
 * Une pièce est caractérisée par une couleur et une direction.
 * Les cases vides et neutres sont également traitées comme des pièces.
 */
class PieceSquadro
{

    /**
     * Constantes pour les couleurs.
     * @var int
     */
    public const BLANC = 0;
    public const NOIR = 1;
    public const VIDE = -1;
    public const NEUTRE = -2;

    /**
     * Constantes pour les directions.
     */
    public const NORD = 0;
    public const EST = 1;
    public const SUD = 2;
    public const OUEST = 3;


    /**
     * @var int $couleur La couleur de la pièce (BLANC, NOIR, VIDE ou NEUTRE).
     */
    protected int $couleur;

    /**
     * @var int $direction La direction de la pièce (NORD, EST, SUD ou OUEST).
     */
    protected int $direction;

    /**
     * Constructeur privé pour initialiser une pièce.
     *
     * @param int $couleur La couleur de la pièce.
     * @param int $direction La direction de la pièce.
     */
    private function __construct(int $couleur, int $direction)
    {
        $this->couleur = $couleur;
        $this->direction = $direction;
    }

    /**
     * Récupère la couleur de la pièce.
     *
     * @return int La couleur de la pièce.
     */
    public function getCouleur(): int
    {
        return $this->couleur;
    }

    /**
     * Récupère la direction de la pièce.
     *
     * @return int La direction de la pièce.
     */
    public function getDirection(): int
    {
        return $this->direction;
    }

    /**
     * Inverse la direction de la pièce (retourne la direction opposée).
     */
    public function inverseDirection(): void
    {
        $this->direction = ($this->direction + 2) % 4;
    }

    /**
     * Méthode de classe pour initialiser une pièce vide.
     *
     * @return PieceSquadro Une instance de pièce vide.
     */
    public static function initVide(): PieceSquadro
    {
        return new self(self::VIDE, self::VIDE);
    }

    /**
     * Méthode de classe pour initialiser une pièce neutre.
     *
     * @return PieceSquadro Une instance de pièce neutre.
     */
    public static function initNeutre(): PieceSquadro
    {
        return new self(self::NEUTRE, self::NEUTRE);
    }

    /**
     * Méthode de classe pour initialiser une pièce noire au nord.
     *
     * @return PieceSquadro Une instance de pièce noire au nord.
     */
    public static function initNoirNord(): PieceSquadro
    {
        return new self(self::NOIR, self::NORD);
    }

    /**
     * Méthode de classe pour initialiser une pièce noire au sud.
     *
     * @return PieceSquadro Une instance de pièce noire au sud.
     */
    public static function initNoirSud(): PieceSquadro
    {
        return new self(self::NOIR, self::SUD);
    }

    /**
     * Méthode de classe pour initialiser une pièce blanche à l'est.
     *
     * @return PieceSquadro Une instance de pièce blanche à l'est.
     */
    public static function initBlancEst(): PieceSquadro
    {
        return new self(self::BLANC, self::EST);
    }

    /**
     * Méthode de classe pour initialiser une pièce blanche à l'ouest.
     *
     * @return PieceSquadro Une instance de pièce blanche à l'ouest.
     */
    public static function initBlancOuest(): PieceSquadro
    {
        return new self(self::BLANC, self::OUEST);
    }

    /**
     * Représentation de la pièce en chaîne de caractères (format JSON).
     *
     * @return string La représentation JSON de la pièce.
     */
    public function __toString(): string
    {
        return json_encode([
            'couleur' => $this->couleur,
            'direction' => $this->direction
        ]);
    }

    /**
     * Conversion de la pièce en JSON.
     *
     * @return string La représentation JSON de la pièce.
     */
    public function toJson(): string
    {
        return $this->__toString();
    }

    /**
     * Création d'une instance de pièce à partir d'un JSON.
     *
     * @param string $json La chaîne JSON représentant une pièce.
     * @return PieceSquadro Une instance de PieceSquadro.
     * @throws InvalidArgumentException Si le format JSON est invalide.
     */
    public static function fromJson(string $json): PieceSquadro
    {
        $data = json_decode($json, true);
        if (!is_array($data) || !isset($data['couleur']) || !isset($data['direction'])) {
            throw new InvalidArgumentException("Invalid JSON format for PieceSquadro");
        }
        return new self($data['couleur'], $data['direction']);
    }
}
