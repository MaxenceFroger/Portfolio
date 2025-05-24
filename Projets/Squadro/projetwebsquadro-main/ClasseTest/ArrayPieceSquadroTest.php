<?php

namespace Squadro\ClasseTest;

use Squadro\Classe\ArrayPieceSquadro;
use Squadro\Classe\PieceSquadro;

require_once '../Classe/ArrayPieceSquadro.php';
require_once '../Classe/PieceSquadro.php';

/**
 * Classe de test pour ArrayPieceSquadro.
 */
class ArrayPieceSquadroTest
{
    /**
     * Teste l'ajout de pièces.
     */
    public function testAddPiece(): void
    {
        $arrayPiece = new ArrayPieceSquadro();
        $piece = PieceSquadro::initNoirNord();
        $arrayPiece->add($piece);

        if (count($arrayPiece) === 1) {
            print("ok1 - Ajout de pièce réussi\n");
        }
        if ($arrayPiece[0] === $piece) {
            print("ok2 - La pièce ajoutée est correcte\n");
        }
    }

    /**
     * Teste la suppression d'une pièce.
     */
    public function testRemovePiece(): void
    {
        $arrayPiece = new ArrayPieceSquadro();
        $piece1 = PieceSquadro::initNoirNord();
        $piece2 = PieceSquadro::initNoirSud();

        $arrayPiece->add($piece1);
        $arrayPiece->add($piece2);
        $arrayPiece->remove(0);

        if (count($arrayPiece) === 1) {
            print("ok3 - Suppression d'une pièce réussie\n");
        }
        if ($arrayPiece[0] === $piece2) {
            print("ok4 - La pièce restante est correcte\n");
        }
    }

    /**
     * Teste la méthode __toString().
     */
    public function testToString(): void
    {
        $arrayPiece = new ArrayPieceSquadro();
        $piece1 = PieceSquadro::initNoirNord();
        $piece2 = PieceSquadro::initNoirSud();

        $arrayPiece->add($piece1);
        $arrayPiece->add($piece2);
        $expected = "{\"couleur\":1,\"direction\":0}, {\"couleur\":1,\"direction\":2}";
        if ($arrayPiece->__toString() === $expected) {
            print("ok5 - Conversion en chaîne réussie\n");
        }
    }

    /**
     * Teste la sérialisation et désérialisation en JSON.
     */
    public function testJson(): void
    {
        $arrayPiece = new ArrayPieceSquadro();
        $piece = PieceSquadro::initNoirNord();
        $arrayPiece->add($piece);

        $json = $arrayPiece->toJson();
        $newArrayPiece = ArrayPieceSquadro::fromJson($json);

        if (count($newArrayPiece) === 1) {
            print("ok6 - Désérialisation réussie\n");
        }
        if ((string)$newArrayPiece[0] === (string)$piece) {
            print("ok7 - Les pièces sont identiques après désérialisation\n");
        }
    }

    /**
     * Teste les méthodes ArrayAccess.
     */
    public function testArrayAccess(): void
    {
        $arrayPiece = new ArrayPieceSquadro();
        $piece1 = PieceSquadro::initNoirNord();
        $piece2 = PieceSquadro::initNoirSud();

        $arrayPiece[0] = $piece1;
        $arrayPiece[1] = $piece2;

        if ($arrayPiece[0] === $piece1) {
            print("ok8 - Lecture via ArrayAccess réussie\n");
        }
        if ($arrayPiece[1] === $piece2) {
            print("ok9 - Lecture via ArrayAccess réussie pour la deuxième pièce\n");
        }
        unset($arrayPiece[0]);
        if (count($arrayPiece) === 1) {
            print("ok10 - Suppression via ArrayAccess réussie\n");
        }
    }

    /**
     * Teste la méthode count().
     */
    public function testCount(): void
    {
        $arrayPiece = new ArrayPieceSquadro();
        $piece1 = PieceSquadro::initNoirNord();
        $piece2 = PieceSquadro::initNoirSud();

        $arrayPiece->add($piece1);
        $arrayPiece->add($piece2);

        if (count($arrayPiece) === 2) {
            print("ok11 - Le nombre de pièces est correct\n");
        }
    }

    /**
     * Point d'entrée pour exécuter tous les tests.
     */
    public function main(): void
    {
        $this->testAddPiece();
        $this->testRemovePiece();
        $this->testToString();
        $this->testJson();
        $this->testArrayAccess();
        $this->testCount();
    }
}

(new ArrayPieceSquadroTest())->main();

