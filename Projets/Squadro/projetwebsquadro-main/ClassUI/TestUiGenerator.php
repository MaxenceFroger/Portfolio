<?php

use Squadro\ClassUI\PieceSquadroUI;
use Squadro\ClassUI\SquadroUIGenerator;
require_once "SquadroUIGenerator.php";
session_start();
$p = new PieceSquadroUI();
$uiGenerator = new SquadroUIGenerator($p,"TestUiGenerator.php","testPageConfirme.php","testPageVictoire.php");

// Test de la page de jeu
echo $uiGenerator->pageJouerPiece();

