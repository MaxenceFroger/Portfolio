<?php
namespace Squadro\ClasseTest;

require_once '../Classe/PieceSquadro.php';

use Squadro\Classe\PieceSquadro;

/**
 * Classe de test pour la classe PieceSquadro.
 */
class PieceSquadroTest
{
    /**
     * Teste l'initialisation d'une pièce vide.
     */
    public function testInitVide(): void
    {
        $piece = PieceSquadro::initVide();
        if(PieceSquadro::VIDE == $piece->getCouleur())  {
            echo("ok1\n");
        }
        if(PieceSquadro::VIDE == $piece->getDirection())  {
            echo("ok2\n");
        }
    }

    /**
     * Teste l'initialisation d'une pièce neutre.
     */
    public function testInitNeutre(): void
    {
        $piece = PieceSquadro::initNeutre();
        if(PieceSquadro::NEUTRE == $piece->getCouleur())  {
            echo("ok3\n");
        }
        if(PieceSquadro::NEUTRE == $piece->getDirection())  {
            echo("ok4\n");
        }
    }

    /**
     * Teste l'initialisation d'une pièce noire orientée au nord.
     */
    public function testInitNoirNord(): void
    {
        $piece = PieceSquadro::initNoirNord();
        if(PieceSquadro::NOIR == $piece->getCouleur())  {
            echo("ok5\n");
        }
        if(PieceSquadro::NORD == $piece->getDirection())  {
            echo("ok6\n");
        }
    }

    /**
     * Teste l'initialisation d'une pièce noire orientée au sud.
     */
    public function testInitNoirSud(): void
    {
        $piece = PieceSquadro::initNoirSud();
        if(PieceSquadro::NOIR == $piece->getCouleur())  {
            echo("ok7\n");
        }
        if(PieceSquadro::SUD == $piece->getDirection())  {
            echo("ok8\n");
        }
    }

    /**
     * Teste l'initialisation d'une pièce blanche orientée à l'est.
     */
    public function testInitBlancEst(): void
    {
        $piece = PieceSquadro::initBlancEst();
        if(PieceSquadro::BLANC == $piece->getCouleur())  {
            echo("ok9\n");
        }
        if(PieceSquadro::EST == $piece->getDirection())  {
            echo("ok10\n");
        }
    }

    /**
     * Teste l'initialisation d'une pièce blanche orientée à l'ouest.
     */
    public function testInitBlancOuest(): void
    {
        $piece = PieceSquadro::initBlancOuest();
        if(PieceSquadro::BLANC == $piece->getCouleur())  {
            echo("ok11\n");
        }
        if(PieceSquadro::OUEST == $piece->getDirection())  {
            echo("ok12\n");
        }
    }

    /**
     * Teste la méthode __toString().
     */
    public function testToString(): void
    {
        $piece = PieceSquadro::initNoirNord();
        echo("PieceSquadro [Couleur: 1, Direction: 0]" . (string)$piece) . "\n";
    }

    /**
     * Teste la méthode inverseDirection().
     */
    public function testInverseDirection(): void
    {
        // vérif retournement pièces blanches
        $piece = PieceSquadro::initBlancOuest();
        $piece->inverseDirection();
        $direction = $piece->getDirection();
        if(PieceSquadro::EST == $direction)  {
            echo("ok13\n");
        }
        // vérif retournement pièces noires
        $piece = PieceSquadro::initNoirNord();
        $piece->inverseDirection();
        $direction = $piece->getDirection();
        if(PieceSquadro::SUD == $direction)  {
            echo("ok14\n");
        }
    }

    /**
     * Test la réversibilité de la méthode toJson avec la méthode fromJson
     */
    public function testJson(): void
    {
        $piece = PieceSquadro::initNoirNord();
        $json = $piece->toJson();
        $pieceFromJson = PieceSquadro::fromJson($json);
        if($json == $pieceFromJson->toJson())  {
            echo("ok15\n");
        }
        if($pieceFromJson->getCouleur() == $piece->getCouleur())  {
            echo("ok16\n");
        }
        if($pieceFromJson->getDirection() == $piece->getDirection())  {
            echo("ok17\n");
        }
    }
    function main(): void
    {
        $this->testInitVide();
        $this->testInitNeutre();
        $this->testInitNoirNord();
        $this->testInitNoirSud();
        $this->testInitBlancEst();
        $this->testInitBlancOuest();
        $this->testToString();
        $this->testInverseDirection();
        $this->testJson();
    }
}
(new PieceSquadroTest)->main();
?>