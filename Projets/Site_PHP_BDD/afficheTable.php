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
      displayAthletes($link);
      break;
    case 'epreuve':
      displayEpreuves($link);
      break;
    case 'pays':
      displayPays($link);
      break;
    case 'participe':
      displayParticipes($link);
      break;
    case 'envoie':
      displayEnvoies($link);
      break;
  }
  $html .= "<a href='accueil.php'> Retour </a>";
  $html .= getFinHTML();
  echo($html);
?>
