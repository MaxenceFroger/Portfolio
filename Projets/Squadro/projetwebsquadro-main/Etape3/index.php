<?php

use Squadro\ClassUI\PieceSquadroUI;
use Squadro\ClassUI\SquadroUIGenerator;

require_once "../ClassUI/SquadroUIGenerator.php";

session_start();

if (!isset($_SESSION["etat"])){
    $_SESSION["etat"] = "choixPiece";
}

$SquadroUIGen = new SquadroUIGenerator(new PieceSquadroUI(), "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php");

if ($_SESSION["etat"] == "choixPiece"){
    echo $SquadroUIGen->pageJouerPiece();
} elseif ($_SESSION["etat"] == "confirmationPiece"){
    echo $SquadroUIGen->pageConfirmerDeplacement();
} elseif ($_SESSION["etat"] == "erreur") {
    echo $SquadroUIGen->pageErreur();
} elseif ($_SESSION['etat'] == "victoire") {
    echo $SquadroUIGen->pagePlateauFinal($_SESSION['joueurActif']);
}

