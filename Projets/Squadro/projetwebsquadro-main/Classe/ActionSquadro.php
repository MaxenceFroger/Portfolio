<?php

namespace Squadro\Classe;

use Exception;

require_once 'PlateauSquadro.php';

/**
 * Classe gérant les actions du jeu Squadro.
 */
class ActionSquadro
{
    /**
     * Instance du plateau de jeu.
     *
     * @var PlateauSquadro
     */
    public PlateauSquadro $plateau;

    /**
     * Constructeur de la classe ActionSquadro.
     *
     * @param PlateauSquadro $p Instance du plateau de jeu.
     */
    public function __construct(PlateauSquadro $p)
    {
        $this->plateau = $p;
    }

    /**
     * Vérifie si une pièce est jouable.
     *
     * Une pièce est jouable si elle existe et que sa destination est vide.
     *
     * @param int $x Coordonnée en ligne de la pièce.
     * @param int $y Coordonnée en colonne de la pièce.
     * @return bool True si la pièce est jouable, false sinon.
     */
    public function estJouablePiece(int $x, int $y): bool
    {
        $piece = $this->plateau->getPiece($x, $y);
        // Vérification que la pièce existe et n'est pas vide
        if (!$piece || $piece->getCouleur() === PieceSquadro::VIDE) {
            return false;
        }

        // Calcul des coordonnées de destination
        [$destX, $destY] = $this->plateau->getCoordDestination($x, $y);

        // Vérification que la destination est vide
        $pieceDestination = $this->plateau->getPiece($destX, $destY);
        return $pieceDestination && $pieceDestination->getCouleur() === PieceSquadro::VIDE;
    }


    /**
     * Joue une pièce en déplaçant et en appliquant les règles.
     *
     * Si la pièce enjambe d'autres pièces, celles-ci reculent.
     * Une pièce peut changer de direction ou être retirée si elle atteint une case de retournement ou de sortie.
     *
     * @param int $x Coordonnée en ligne de départ.
     * @param int $y Coordonnée en colonne de départ.
     * @return void
     * @throws Exception
     */
    public function jouePiece(int $x, int $y): void
    {

        if (!$this->estJouablePiece($x, $y)) {
            throw new Exception("Piece $x $y non jouable");
        }

        $piece = $this->plateau->getPiece($x, $y);
        [$destX, $destY] = $this->plateau->getCoordDestination($x, $y);

        // Gestion des sauts et reculs
        $stepX = $destX === $x ? 0 : ($destX > $x ? 1 : -1);
        $stepY = $destY === $y ? 0 : ($destY > $y ? 1 : -1);

        $currentX = $x + $stepX;
        $currentY = $y + $stepY;
        while ($currentX !== $destX || $currentY !== $destY) {
            $pieceEnChemin = $this->plateau->getPiece($currentX, $currentY);
            if ($pieceEnChemin !== null && $pieceEnChemin->getCouleur() != PieceSquadro::VIDE) {
                if ($pieceEnChemin->getCouleur() !== $piece->getCouleur()) {
                    // Si la case est occupée par une pièce ennemie, la pièce saute
                    $this->reculerPieceAdversaire($currentX, $currentY); // Recule la pièce ennemie
                }
            }
            $currentX += $stepX;
            $currentY += $stepY;
        }

        // Déplacement de la pièce
        $this->plateau->setPiece(PieceSquadro::initVide(), $x, $y);
        $this->plateau->setPiece($piece, $destX, $destY);
        // Vérification des règles spéciales (retournement ou sortie)
        if ($destX === 0 || $destY === 6) {
            $piece->inverseDirection();
        }
        if ($destX === 6 || $destY === 0) {
            $couleur = $piece->getCouleur();
            if ($couleur === PieceSquadro::BLANC) {
                $this->sortPiece($piece->getCouleur(), $destX);
            } else {
                $this->sortPiece($piece->getCouleur(), $destY);
            }
        }
    }

    /**
     * Fait reculer une pièce adverse à son point de départ.
     *
     * @param int $x Coordonnée en ligne de la pièce adverse.
     * @param int $y Coordonnée en colonne de la pièce adverse.
     * @return void
     */
    public function reculerPieceAdversaire(int $x, int $y): void
    {
        $piece = $this->plateau->getPiece($x, $y);
        if ($piece === null || $piece->getCouleur() === PieceSquadro::VIDE) {
            return;
        }

        // Déterminer le point de départ en fonction de la direction de la pièce
        switch ($piece->getDirection()) {
            case 0: // NORD
                $pointDeDepart = [6, $y]; // Le point de départ est à x = 6 (ligne) et y reste inchangé
                break;
            case 1: // EST
                $pointDeDepart = [$x, 0]; // Le point de départ est à x inchangé et y = 0
                break;
            case 2: // SUD
                $pointDeDepart = [0, $y]; // Le point de départ est à x = 0 (ligne) et y reste inchangé
                break;
            case 3: // OUEST
                $pointDeDepart = [$x, 6]; // Le point de départ est à x inchangé et y = 6
                break;
            default:
                // Si la direction est invalide, ne rien faire
                return;
        }

        // Remettre la pièce à son point de départ
        $this->plateau->setPiece(PieceSquadro::initVide(), $x, $y);
        $this->plateau->setPiece($piece, $pointDeDepart[0], $pointDeDepart[1]);
    }


    /**
     * Retire une pièce du plateau (sortie).
     *
     * @param int $couleur Couleur de la pièce.
     * @param int $valeur Valeur x ou y de la ligne ou colonne où il faut sortir la pièce
     * @return void
     */
    public function sortPiece(int $couleur, int $valeur): void
    {
        if ($couleur == PieceSquadro::BLANC) {
            $index = in_array($valeur, $this->plateau->getLignesJouables());
            if ($index !== false) {
                $this->plateau->retireLigneJouableValeur($valeur);
            }
            $piece = PieceSquadro::initVide();
            $this->plateau->setPiece($piece, $valeur, 0);
        } else {
            $index = in_array($valeur, $this->plateau->getColonnesJouables());

            if ($index !== false) {
                $this->plateau->retireColonneJouableValeur($valeur);
            }
            $piece = PieceSquadro::initVide();
            $this->plateau->setPiece($piece, 6, $valeur);
        }
    }

    /**
     * Vérifie si une couleur a remporté la partie.
     *
     * Une couleur gagne si elle a 4 pièces sorties.
     *
     * @param int $couleur Couleur des pièces.
     * @return bool True si la victoire est atteinte, false sinon.
     */
    public function remporteVictoire(int $couleur): bool
    {
        $sorties = false;
        if ($couleur == 0) {
            if (sizeof($this->plateau->getLignesJouables()) <= 1) {
                $sorties = true;
            }
        } else {
            if (sizeof($this->plateau->getColonnesJouables()) <= 1) {
                $sorties = true;
            }
        }
        return $sorties;
    }
}
