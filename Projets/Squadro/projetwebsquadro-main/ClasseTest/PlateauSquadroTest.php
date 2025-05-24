<?php

namespace Squadro\ClasseTest;

use Squadro\Classe\PieceSquadro;
use Squadro\Classe\PlateauSquadro;

require_once '../Classe/PlateauSquadro.php';

/**
 * Classe de test pour la classe PlateauSquadro.
 */
class PlateauSquadroTest
{
    /**
     * Teste l'initialisation du plateau avec les cases correctement définies.
     */
    public function testInitialisation(): void
    {
        print_r("plateau avec les couleurs");
        $plateau = new PlateauSquadro();
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                printf("%3d", $plateau->getPiece($i, $j)->getCouleur());
            }
            print("\n");
        }
        print_r("plateau avec les directions");
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                printf("%3d", $plateau->getPiece($i, $j)->getDirection());
            }
            print("\n");
        }
    }

    /**
     * Teste l'ajout et la récupération d'une pièce.
     */
    public function testSetAndGetPiece(): void
    {
        $plateau = new PlateauSquadro();
        $piece = PieceSquadro::initNoirSud();
        $plateau->setPiece($piece, 3, 3);

        if ($plateau->getPiece(3, 3) === $piece) {
            print("ok1 (3, 3)\n");
        }
    }

    /**
     * Teste les coordonnées de destination.
     */
    public function testGetCoordDestination(): void
    {
        $plateau = new PlateauSquadro();
        $piece = PieceSquadro::initNoirNord();
        $plateau->setPiece($piece, 3, 3);

        [$destX, $destY] = $plateau->getCoordDestination(3, 3);
        if ($destX === 1 && $destY === 3) {
            print("ok2 (1, 3)\n");
        }
    }

    /**
     * Teste les lignes et colonnes jouables.
     */
    public function testLignesColonnesJouables(): void
    {
        $plateau = new PlateauSquadro();
        $lignes = $plateau->getLignesJouables();
        $colonnes = $plateau->getColonnesJouables();

        if ($lignes === [1, 2, 3, 4, 5]) {
            print("ok3 (lignes jouables)\n");
        }
        if ($colonnes === [1, 2, 3, 4, 5]) {
            print("ok4 (colonnes jouables)\n");
        }

        $plateau->retireLigneJouable(3);
        $plateau->retireColonneJouable(4);

        if ($plateau->getLignesJouables() == [1, 2, 3, 5]) {
            print("ok5 (lignes après retrait)\n");
        }
        if ($plateau->getColonnesJouables() === [1, 2, 3, 4]) {
            print("ok6 (colonnes après retrait)\n");
        }
    }

    /**
     * Teste la sérialisation et désérialisation JSON.
     */
    public function testJson(): void
    {
        $plateau = new PlateauSquadro();
        $json = $plateau->toJson();
        $plateauFromJson = PlateauSquadro::fromJson($json);

        if ($json === $plateauFromJson->toJson()) {
            print("ok7 (JSON sérialisation)\n");
        }
    }

    /**
     * Teste la méthode __toString().
     */
    public function testToString(): void
    {
        $plateau = new PlateauSquadro();
        $stringRepresentation = (string)$plateau;

        if (is_string($stringRepresentation) && strlen($stringRepresentation) > 0) {
            print("ok8 (__toString)\n");
        }
    }

    /**
     * Fonction principale pour exécuter les tests.
     */
    public function main(): void
    {
        $this->testInitialisation();
        $this->testSetAndGetPiece();
        $this->testGetCoordDestination();
        $this->testLignesColonnesJouables();
        $this->testJson();
        $this->testToString();
    }
}

// Exécute les tests
(new PlateauSquadroTest())->main();

