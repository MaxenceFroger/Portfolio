<?php
include 'fonctions_athlete.php';
include 'fonctions_epreuve.php';
include 'fonctions_pays.php';
include 'fonctions_participe.php';
include 'fonctions_envoie.php';
include 'fonctions_multi_table.php';
include 'fonctions_html.php';
include 'formulaire_athlete.php';
include 'formulaire_epreuve.php';
include 'formulaire_pays.php';
include 'formulaire_participe.php';
include 'formulaire_envoie.php';

$link = connexion();
displayAthletes($link);
echo("---------------------");
displayEpreuves($link);
echo("---------------------");
displayPays($link);
echo("---------------------");
displayEnvoies($link);
echo("---------------------");
displayParticipes($link);


$html = getDebutHTML("Ski Alpin");
$html .= formulaireAddAthlete();
$html .= formulaireDeleteAthlete();
$html .= formulaireModifierAthlete(getAthleteById('1',$link));
$html .= formulaireAddEpreuve();
$html .= formulaireDeleteEpreuve();
$html .= formulaireModifierEpreuve(getEpreuveById('1',$link));
$html .= formulaireAddPays();
$html .= formulaireDeletePays();
$html .= formulaireModifierPays(getPaysById('1',$link));
$html .= formulaireAddParticipe();
$html .= formulaireDeleteParticipe();
$html .= formulaireModifierParticipe();
$html .= formulaireAddEnvoie();
$html .= formulaireDeleteEnvoie();
$html .= getFinHTML();
echo($html);
?>
