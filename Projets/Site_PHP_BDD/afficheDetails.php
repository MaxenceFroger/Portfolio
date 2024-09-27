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
      showAthleteById($_SESSION['showID'], $link);
      break;
    case 'epreuve':
      showEpreuveById($_SESSION['showID'], $link);
      break;
    case 'pays':
      showPaysById($_SESSION['showID'], $link);
      break;
    case 'participe':
      showParticipeById($_SESSION['showID']['athlete_id'], $_SESSION['showID']['epreuve_id'], $link);
      break;
    case 'envoie':
      showEnvoieById($_SESSION['showID']['athlete_id'], $_SESSION['showID']['pays_id'], $link);
      break;
  }
  $html .= "<a href='afficheTable.php'> Retour </a>";
  $html .= getFinHTML();
  echo($html);
?>
