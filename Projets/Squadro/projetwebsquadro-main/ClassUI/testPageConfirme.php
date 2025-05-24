<?php

use Squadro\ClassUI\PieceSquadroUI;
use Squadro\ClassUI\SquadroUIGenerator;
require_once "SquadroUIGenerator.php";
session_start();
$p = new PieceSquadroUI();
$uiGenerator = new SquadroUIGenerator($p,"TestUiGenerator.php","testPageConfirme.php","testPageVictoire.php");

// Test de la page de confirmation de déplacement
$xy = "";
$couleur = "";
if (isset($_POST['piece_noire'])) {
    $xy = $_POST['piece_noire'];
    $couleur = "noire";
}
if (isset($_POST['piece_blanche'])) {
    $xy = $_POST['piece_blanche'];
    $couleur = "blanche";
}
echo $uiGenerator->pageConfirmerDeplacement($xy, $couleur);

