<?php

namespace Squadro\Classe;

require_once 'ArrayPieceSquadro.php';

/**
 * Classe représentant le plateau du jeu Squadro.
 */
class PlateauSquadro
{
    /**
     * Vitesses de déplacement des pièces blanches à l'aller.
     * @access public
     * @var array<int>
     */
    public const BLANC_V_ALLER = [0, 1, 3, 2, 3, 1, 0];

    /**
     * Vitesses de déplacement des pièces blanches au retour.
     * @access public
     * @var array<int>
     */
    public const BLANC_V_RETOUR = [0, 3, 1, 2, 1, 3, 0];

    /**
     * Vitesses de déplacement des pièces noires à l'aller.
     * @access public
     * @var array<int>
     */
    public const NOIR_V_ALLER = [0, 3, 1, 2, 1, 3, 0];

    /**
     * Vitesses de déplacement des pièces noires au retour.
     * @access public
     * @var array<int>
     */
    public const NOIR_V_RETOUR = [0, 1, 3, 2, 3, 1, 0];

    /**
     * Plateau constitué de 7 lignes, chacune représentée par une instance d'ArrayPieceSquadro.
     * @access private
     * @var array<int, ArrayPieceSquadro>
     */
    private array $plateau;

    /**
     * Lignes jouables pour les pièces blanches.
     * @access private
     * @var array<int>
     */
    private array $lignesJouables = [1, 2, 3, 4, 5];

    /**
     * Colonnes jouables pour les pièces noires.
     * @access private
     * @var array<int>
     */
    private array $colonnesJouables = [1, 2, 3, 4, 5];


    /**
     * Constructeur de la classe PlateauSquadro.
     * Initialise les cases vides, neutres, blanches et noires.
     * @access public
     */
    public function __construct()
    {
        $this->plateau = [];
        for ($i = 0; $i < 7; $i++) {
            $this->plateau[$i] = new ArrayPieceSquadro();
        }
        $this->initCasesVides(); // Étape 1
        $this->initCasesNeutres(); // Étape 2
        $this->initCasesBlanches(); // Étape 3
        $this->initCasesNoires(); // Étape 4
    }

    /**
     * Initialise toutes les cases du plateau comme vides.
     * @access private
     */
    private function initCasesVides(): void
    {
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                $this->plateau[$i]->offsetSet($j, PieceSquadro::initVide());
            }
        }
    }

    /**
     * Initialise les cases neutres (coins).
     * @access private
     */
    private function initCasesNeutres(): void
    {
        $this->plateau[0]->offsetSet(0, PieceSquadro::initNeutre()); // Coin nord-ouest
        $this->plateau[0]->offsetSet(6, PieceSquadro::initNeutre()); // Coin nord-est
        $this->plateau[6]->offsetSet(0, PieceSquadro::initNeutre()); // Coin sud-ouest
        $this->plateau[6]->offsetSet(6, PieceSquadro::initNeutre()); // Coin sud-est
    }

    /**
     * Initialise les cases blanches (ligne de départ des pièces blanches à l'ouest).
     * @access private
     */
    private function initCasesBlanches(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->plateau[$i]->offsetSet(0, PieceSquadro::initBlancEst());
        }
    }

    /**
     * Initialise les cases noires (ligne de départ des pièces noires au sud).
     * @access private
     */
    private function initCasesNoires(): void
    {
        for ($j = 1; $j <= 5; $j++) {
            $this->plateau[6]->offsetSet($j, PieceSquadro::initNoirNord());
        }
    }

    /**
     * Retourne l'intégralité du plateau.
     * @access public
     * @return array<int, ArrayPieceSquadro>
     */
    public function getPlateau(): array
    {
        return $this->plateau;
    }

    /**
     * Retourne une pièce à une position donnée.
     * @access public
     * @param int $x Coordonnée en ligne.
     * @param int $y Coordonnée en colonne.
     * @return PieceSquadro
     */
    public function getPiece(int $x, int $y): PieceSquadro
    {
        return $this->plateau[$x]->offsetGet($y);
    }

    /**
     * Place une pièce à une position donnée.
     * @access public
     * @param PieceSquadro $piece La pièce à placer.
     * @param int $x Coordonnée en ligne.
     * @param int $y Coordonnée en colonne.
     */
    public function setPiece(PieceSquadro $piece, int $x, int $y): void
    {
        $this->plateau[$x]->offsetSet($y, $piece);
    }

    /**
     * Retourne les lignes jouables.
     * @access public
     * @return array<int>
     */
    public function getLignesJouables(): array
    {
        return $this->lignesJouables;
    }

    /**
     * Retourne les colonnes jouables.
     * @access public
     * @return array<int>
     */
    public function getColonnesJouables(): array
    {
        return $this->colonnesJouables;
    }

    /**
     * Retire une ligne jouable.
     * @access public
     * @param int $index L'index de la ligne à retirer.
     */
    public function retireLigneJouable(int $index): void
    {
        if (in_array($index, $this->lignesJouables)) {
            array_splice($this->lignesJouables, $index, 1);
        }
    }

    /**
     * Retire une colonne jouable.
     * @access public
     * @param int $index L'index de la colonne à retirer.
     */
    public function retireColonneJouable(int $index): void
    {
        if (in_array($index, $this->colonnesJouables)) {
            array_splice($this->colonnesJouables, $index, 1);
        }
    }

    /**
     * Retire une ligne jouable.
     * @access public
     * @param int $valeur La valeur de la ligne à retirer.
     */
    public function retireLigneJouableValeur(int $valeur): void
    {
        $index = array_search($valeur, $this->lignesJouables); // Trouver l'index réel
        if ($index !== false) {
            array_splice($this->lignesJouables, $index, 1);
        }
    }

    /**
     * Retire une colonne jouable.
     * @access public
     * @param int $valeur La valeur de la colonne à retirer.
     */
    public function retireColonneJouableValeur(int $valeur): void
    {
        $index = array_search($valeur, $this->colonnesJouables); // Trouver l'index réel
        if ($index !== false) {
            array_splice($this->colonnesJouables, $index, 1);
        }
    }

    /**
     * Retourne les coordonnées de destination d'une pièce après son déplacement.
     * @access public
     * @param int $x Coordonnée initiale en ligne.
     * @param int $y Coordonnée initiale en colonne.
     * @return array<int>
     */
    public function getCoordDestination(int $x, int $y): array
    {
        $piece = $this->getPiece($x, $y);

        if ($piece->getCouleur() === PieceSquadro::BLANC) {
            $vitesse = $piece->getDirection() === PieceSquadro::EST
                ? self::BLANC_V_ALLER[$x]
                : self::BLANC_V_RETOUR[$x];
        } else { // NOIR
            $vitesse = $piece->getDirection() === PieceSquadro::NORD
                ? self::NOIR_V_ALLER[$y]
                : self::NOIR_V_RETOUR[$y];
        }

        return match ($piece->getDirection()) {
            PieceSquadro::NORD => [$x - $vitesse, $y],
            PieceSquadro::SUD => [$x + $vitesse, $y],
            PieceSquadro::EST => [$x, $y + $vitesse],
            PieceSquadro::OUEST => [$x, $y - $vitesse],
            default => [$x, $y],
        };
    }



    /**
     * Retourne une pièce à la destination calculée.
     * @access public
     * @param int $x Coordonnée initiale en ligne.
     * @param int $y Coordonnée initiale en colonne.
     * @return PieceSquadro
     */
    public function getDestination(int $x, int $y): PieceSquadro
    {
        [$destX, $destY] = $this->getCoordDestination($x, $y);
        return $this->getPiece($destX, $destY);
    }

    /**
     * Sérialise le plateau en JSON.
     * @access public
     * @return string
     */
    public function toJson(): string
    {
        $data = [
            'lignesJouables' => $this->lignesJouables,
            'colonnesJouables' => $this->colonnesJouables,
            'plateau' => array_map(fn($ligne) => json_decode($ligne->toJson(), true), $this->plateau)
        ];

        return json_encode($data);
    }

    /**
     * Désérialise un JSON pour recréer une instance de PlateauSquadro.
     * @access public
     * @param string $json La chaîne JSON à désérialiser.
     * @return PlateauSquadro
     */
    public static function fromJson(string $json): PlateauSquadro
    {
        $data = json_decode($json, true);

        $plateau = new PlateauSquadro();

        $plateau->lignesJouables = $data['lignesJouables'] ?? [];
        $plateau->colonnesJouables = $data['colonnesJouables'] ?? [];

        // Restaurer l'état du plateau avec les autres informations
        foreach ($data['plateau'] as $x => $ligne) {
            $plateau->plateau[$x] = ArrayPieceSquadro::fromJson(json_encode($ligne));
        }
        return $plateau;
    }

    /**
     * Représentation du plateau sous forme de chaîne.
     * @access public
     * @return string
     */
    public function __toString(): string
    {
        return implode("\n", array_map(fn($ligne) => $ligne->__toString(), $this->plateau));
    }
}
