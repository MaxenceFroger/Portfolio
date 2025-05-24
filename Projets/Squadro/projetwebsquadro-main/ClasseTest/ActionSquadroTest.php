<?php

namespace Squadro\ClasseTest;

use Exception;
use Squadro\Classe\ActionSquadro;
use Squadro\Classe\PieceSquadro;
use Squadro\Classe\PlateauSquadro;

require_once '../Classe/ActionSquadro.php';

/**
 * Classe de test pour ActionSquadro.
 */
class ActionSquadroTest
{
    /**
     * Teste la vérification de la jouabilité d'une pièce.
     */
    public function testEstJouablePiece(): void
    {
        $plateau = new PlateauSquadro();
        $actionSquadro = new ActionSquadro($plateau);


        if ($actionSquadro->estJouablePiece(1, 0)) {
            print("ok1 (Pièce jouable)\n");
        } else {
            print("erreur1 (Pièce censée être jouable)\n");
        }

        if (!$actionSquadro->estJouablePiece(1, 1)) {
            print("ok2 (Pièce non jouable)\n");
        } else {
            print("erreur2 (Pièce non censée être jouable)\n");
        }
    }

    /**
     * Teste le déplacement d'une pièce.
     */
    public function testJouePiece(): void
    {
        $plateau = new PlateauSquadro();
        $actionSquadro = new ActionSquadro($plateau);

        // Place une pièce à une position jouable
        $plateau->setPiece(PieceSquadro::initNoirNord(), 3, 3);

        $actionSquadro->jouePiece(3, 3);
        print("ok3 (Déplacement réussi)\n");


        // Test de déplacement non jouable
        try {
            $actionSquadro->jouePiece(1, 1);
            print_r("pas normal");
        } catch (Exception) {
            print("ok4 (Exception correcte pour une pièce non jouable)\n");
        }

    }

    /**
     * Teste les règles spécifiques aux sauts et reculs.
     */
    public function testSautsEtReculs(): void
    {
        $plateau = new PlateauSquadro();
        $actionSquadro = new ActionSquadro($plateau);

        // Place une pièce noire et une pièce blanche adversaire sur le chemin
        $plateau->setPiece(PieceSquadro::initNoirNord(), 3, 3);
        $plateau->setPiece(PieceSquadro::initBlancOuest(), 2, 3);

        $actionSquadro->jouePiece(3, 3);
        $piece = $plateau->getPiece(1, 3);

        if ($piece->getCouleur() === PieceSquadro::NOIR) {
            print("ok5 (Déplacement avec saut correct)\n");
        }

        $plateau = new PlateauSquadro();
        $actionSquadro = new ActionSquadro($plateau);
        $plateau->setPiece(PieceSquadro::initBlancEst(), 2, 1);
        $plateau->setPiece(PieceSquadro::initNoirSud(), 2, 2);
        $plateau->setPiece(PieceSquadro::initNoirNord(), 2, 3);
        $plateau->setPiece(PieceSquadro::initVide(), 0, 2);
        $plateau->setPiece(PieceSquadro::initVide(), 6, 3);

        print_r("plateau avec les couleurs\n");
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                printf("%3d", $plateau->getPiece($i, $j)->getCouleur());
            }
            print("\n");
        }
        [$destX, $destY] = $plateau->getCoordDestination(2, 1);
        print_r($destX . " " . $destY . "\n");
        $actionSquadro->jouePiece(2, 1);
        $piece = $plateau->getPiece(2, 4);


        print_r("plateau avec les couleurs\n");
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                printf("%3d", $plateau->getPiece($i, $j)->getCouleur());
            }
            print("\n");
        }

        if ($piece->getCouleur() === PieceSquadro::BLANC &&
            $plateau->getPiece(2, 2)->getCouleur() === PieceSquadro::VIDE &&
            $plateau->getPiece(2, 3)->getCouleur() === PieceSquadro::VIDE &&
            $plateau->getPiece(6, 3)->getCouleur() === PieceSquadro::NOIR &&
            $plateau->getPiece(0, 2)->getCouleur() === PieceSquadro::NOIR) {
            print("ok6 (Déplacement avec saut correct)\n");
        }

        $plateau = new PlateauSquadro();
        $actionSquadro = new ActionSquadro($plateau);
        $plateau->setPiece(PieceSquadro::initNoirNord(), 5, 1);
        $plateau->setPiece(PieceSquadro::initBlancEst(), 4, 1);
        $plateau->setPiece(PieceSquadro::initBlancOuest(), 3, 1);
        $plateau->setPiece(PieceSquadro::initVide(), 4, 0);
        $plateau->setPiece(PieceSquadro::initVide(), 3, 6);

        print_r("plateau avec les couleurs\n");
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                printf("%3d", $plateau->getPiece($i, $j)->getCouleur());
            }
            print("\n");
        }
        [$destX, $destY] = $plateau->getCoordDestination(5, 1);
        print_r($destX . " " . $destY . "\n");
        $actionSquadro->jouePiece(5, 1);
        $piece = $plateau->getPiece(2, 1);


        print_r("plateau avec les couleurs\n");
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                printf("%3d", $plateau->getPiece($i, $j)->getCouleur());
            }
            print("\n");
        }

        if ($piece->getCouleur() === PieceSquadro::NOIR &&
            $plateau->getPiece(4, 1)->getCouleur() === PieceSquadro::VIDE &&
            $plateau->getPiece(3, 1)->getCouleur() === PieceSquadro::VIDE &&
            $plateau->getPiece(4, 0)->getCouleur() === PieceSquadro::BLANC &&
            $plateau->getPiece(3, 6)->getCouleur() === PieceSquadro::BLANC) {
            print("ok7 (Déplacement avec saut correct)\n");
        }
    }

    public function testVictoire(): void
    {
        $plateau = new PlateauSquadro();
        $actionSquadro = new ActionSquadro($plateau);
        if (!$actionSquadro->remporteVictoire(PIECESQUADRO::BLANC)) {
            print("ok8 (Non Victoire Blanc)\n");
        }
        $actionSquadro->sortPiece(PIECESQUADRO::BLANC, 1);
        $actionSquadro->sortPiece(PIECESQUADRO::BLANC, 1);
        $actionSquadro->sortPiece(PIECESQUADRO::BLANC, 1);
        $actionSquadro->sortPiece(PIECESQUADRO::BLANC, 1);
        if ($actionSquadro->remporteVictoire(PIECESQUADRO::BLANC)) {
            print("ok9 (Victoire Blanc)\n");
        }

        $plateau = new PlateauSquadro();
        $actionSquadro = new ActionSquadro($plateau);
        if (!$actionSquadro->remporteVictoire(PIECESQUADRO::NOIR)) {
            print("ok10 (Non Victoire Noir)\n");
        }
        $actionSquadro->sortPiece(PIECESQUADRO::NOIR, 1);
        $actionSquadro->sortPiece(PIECESQUADRO::NOIR, 1);
        $actionSquadro->sortPiece(PIECESQUADRO::NOIR, 1);
        $actionSquadro->sortPiece(PIECESQUADRO::NOIR, 1);
        if ($actionSquadro->remporteVictoire(PIECESQUADRO::NOIR)) {
            print("ok11 (Victoire Noir)\n");
        }
    }

    /**
     * Fonction principale pour exécuter les tests.
     */
    public function main(): void
    {
        $this->testEstJouablePiece();
        $this->testJouePiece();
        $this->testSautsEtReculs();
        $this->testVictoire();
    }
}

// Exécute les tests
(new ActionSquadroTest())->main();
