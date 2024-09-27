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
  session_start();
  $link = connexion();
  $html = getDebutHTML("Accueil");
  switch($_SESSION['table']) {
    case 'athlete':
      $html .= formulaireModifierAthlete(getAthleteById($_SESSION['modifyID'],$link));
      break;
    case 'epreuve':
      $html .= formulaireModifierEpreuve(getEpreuveById($_SESSION['modifyID'],$link));
      break;
    case 'pays':
      $html .= formulaireModifierPays(getPaysById($_SESSION['modifyID'],$link));
      break;
    case 'participe':
      $html .= formulaireModifierParticipe(getParticipeById($_SESSION['modifyID']['athlete_id'], $_SESSION['modifyID']['epreuve_id'], $link));
      break;
    case 'envoie':
      $html .= formulaireModifierEnvoie(getEnvoieById($_SESSION['modifyID']['athlete_id'], $_SESSION['modifyID']['pays_id'], $link));
      break;
  }
  $html .= "<a href='afficheTable.php'> Retour </a>";
  $html .= getFinHTML();
  echo($html);
?>
