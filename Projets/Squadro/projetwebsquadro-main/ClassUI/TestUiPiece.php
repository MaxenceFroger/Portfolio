<?php

use Squadro\ClassUI\PieceSquadroUI;

require_once 'PieceSquadroUI.php';


// Tester les méthodes de génération
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='style.css'>
    <title>Test PieceSquadroUI</title>

</head>
<body>
    <h1>Test de la classe PieceSquadroUI</h1>
    <div class='board'>";

// Tester les méthodes et afficher le résultat
$ui = new PieceSquadroUI();

// Test des différentes méthodes
echo $ui->caseVide();
echo $ui->caseNeutre();
echo $ui->pieceNoire(1, 2, true); // Pièce noire sélectionnée
echo $ui->pieceBlanche(3, 4);     // Pièce blanche non sélectionnée

echo "</div>
</body>
</html>";

